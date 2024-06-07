<?php

namespace App\Filament\Members\Pages;


use Exception;
use Filament\Panel;
use Filament\Forms\Get;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Pages\Concerns;
use Filament\Facades\Filament;
use Filament\Pages\SimplePage;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;

use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use function Filament\Support\is_app_url;
use Illuminate\Validation\Rules\Password;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Contracts\Auth\Authenticatable;
use Marvinosswald\FilamentInputSelectAffix\TextInputSelectAffix;

/**
 * @property Form $form
 */

class EditProfile extends Page implements HasForms
{


    protected static string $view = 'filament.members.pages.edit-profile';

    protected static ?string $title = 'Profile';
    protected static ?string $navigationLabel = 'Profile';
    protected static ?string $navigationIcon = 'heroicon-s-user';

    protected static ?string $slug = 'custom-profile';

    protected ?string $subheading = 'Anda dapat merubah data anda dengan form berikut';

    public ?array $data = [];

    public Customer $customer;



    /**
     * @var array<string, mixed> | null
     */

    public static function getLabel(): string
    {
        return __('filament-panels::pages/auth/edit-profile.label');
    }

    public static function getRelativeRouteName(): string
    {
        return 'profile';
    }

    public static function isTenantSubscriptionRequired(Panel $panel): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->fillForm();
    }

    public function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();

        if (!$user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }

    protected function fillForm(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->callHook('beforeFill');

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    public function save(): void
    {
        try {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeSave($data);

            $this->callHook('beforeSave');

            $this->handleRecordUpdate($this->getUser(), $data);

            $this->callHook('afterSave');
        } catch (Halt $exception) {
            return;
        }

        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put([
                'password_hash_' . Filament::getAuthGuard() => $data['password'],
            ]);
        }

        $this->data['password'] = null;
        $this->data['passwordConfirmation'] = null;

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }

    protected function getSavedNotification(): ?Notification
    {
        $title = $this->getSavedNotificationTitle();

        if (blank($title)) {
            return null;
        }

        return Notification::make()
            ->success()
            ->title($this->getSavedNotificationTitle());
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('filament-panels::pages/auth/edit-profile.notifications.saved.title');
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
        ->label(__('filament-panels::pages/auth/edit-profile.form.name.label'))
        ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
        ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
        ->email()
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
        ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
        ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->rule(Password::default())
            ->autocomplete('new-password')
            ->dehydrated(fn ($state): bool => filled($state))
            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
            ->live(debounce: 500)
            ->same('passwordConfirmation');
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
        ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
        ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->visible(fn (Get $get): bool => filled($get('password')))
            ->dehydrated(false);
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([Section::make('')
                        ->schema([
                            Split::make([
                                Group::make([
                                    FileUpload::make('avatar')
                                        ->image()
                                        ->circleCropper()
                                        ->imagePreviewHeight('250'),
                                    Actions::make([
                                        Actions\Action::make('edit-password')
                                            ->label('Change Password')
                                            ->icon('heroicon-o-key')
                                            ->action(function (Customer $record, array $data): void {
                                                $record->update([
                                                    'password' => Hash::make($data['password']),
                                                ]);
                                            })
                                            ->form([
                                                TextInput::make('password')
                                                    ->label('New Password')
                                                    ->password()
                                                    ->required()
                                                    ->minLength(8)
                                                    ->same('password_confirmation'),
                                                TextInput::make('password_confirmation')
                                                    ->label('Confirm Password')
                                                    ->password()
                                                    ->required()
                                                    ->minLength(8),
                                            ])
                                            ->modalHeading('Change Password')
                                            ->modalButton('Save')
                                            ->modalWidth('lg')
                                    ])->alignCenter(),
                                ])->grow(),
                                Group::make([
                                    TextInput::make('nama_lengkap'),
                                    TextInputSelectAffix::make('no_identitas')
                                        ->integer()
                                        ->required()
                                        ->maxLength(16)
                                        ->minLength(12)
                                        ->helperText('No Identitas sesuai dengan KTP atau SIM')
                                        ->select(
                                            fn () => Select::make('jenis_identitas')
                                                ->options([
                                                    'KTP' => 'KTP',
                                                    'SIM' => 'SIM'
                                                ])
                                                ->default('KTP')
                                                ->selectablePlaceholder(false)
                                        ),
                                    TextInput::make('email'),
                                    TextInput::make('email_verified_at')
                                        ->label('Email Terverifikasi')
                                        ->disabled(),
                                    TextInput::make('alamat'),
                                    TextInput::make('telp'),
                                    ToggleButtons::make('status')
                                        ->options([
                                            'active' => 'Active',
                                            'nonactive' => 'Non-Active',
                                        ])
                                        ->colors([
                                            'active' => 'info',
                                            'nonactive' => 'warning',
                                        ])
                                        ->inline()
                                        ->disabled(),
                                ])
                            ])
                        ])

                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getCancelFormAction(): Action
    {
        return $this->backAction();
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
        ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
        ->submit('save')
        ->keyBindings(['mod+s']);
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function getFormActionsAlignment(): string | Alignment
    {
        return Alignment::Start;
    }

    public function getTitle(): string | Htmlable
    {
        return static::getLabel();
    }

    public static function getSlug(): string
    {
        return static::$slug ?? 'profile';
    }

    public function hasLogo(): bool
    {
        return false;
    }

    /**
     * @deprecated Use `getCancelFormAction()` instead.
     */
    public function backAction(): Action
    {
        return Action::make('back')
        ->label(__('filament-panels::pages/auth/edit-profile.actions.cancel.label'))
        ->url(filament()->getUrl())
            ->color('gray');
    }
}
