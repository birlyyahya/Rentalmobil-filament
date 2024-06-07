<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Page\ViewCustomer;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Actions\Action as ActionForm;
use Filament\Tables\Actions\Action;
use Filament\Infolists\Components\Grid;
use Illuminate\Validation\Rules\Unique;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\CustomerResource\Pages;
use Filament\Infolists\Components\Card as ComponentsCard;
use App\Filament\Resources\CustomerResource\RelationManagers;
use Marvinosswald\FilamentInputSelectAffix\TextInputSelectAffix;
use Filament\Resources\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Support\Facades\Hash;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationGroup = 'Members';


    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Customers';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::latest()->count();
    }


    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInputSelectAffix::make('no_identitas')
                            ->numeric()
                            ->required()
                            ->maxLength(16)
                            ->minLength(12)
                            ->helperText('No Identitas sesuai dengan KTP atau SIM')
                            ->select(
                                fn () => Forms\Components\Select::make('jenis_identitas')
                                    ->options([
                                        'KTP' => 'KTP',
                                        'SIM' => 'SIM'
                                    ])
                                    ->required()
                                    ->default('KTP')
                                    ->selectablePlaceholder(false)
                            ),
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->unique(modifyRuleUsing: function (Unique $rule) {
                                return $rule->where('status', 'non-active');
                            })
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->nullable(),
                        Forms\Components\Textarea::make('alamat')
                            ->required(),
                        Forms\Components\TextInput::make('telp')
                            ->required()
                            ->tel()
                            ->label('No Telephone'),
                        Forms\Components\TextInput::make('password')
                            ->required()
                            ->hiddenOn('edit')
                            ->password()
                            ->minLength(8)
                            ->label('Kata Sandi')
                            ->same('password_confirmation'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Konfirmasi Kata Sandi')
                            ->hiddenOn('edit')
                            ->required()
                            ->password(),
                    ])->columnSpan(8),
                Card::make()
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->alignCenter()
                            ->circleCropper()
                            ->nullable()
                            ->disk('public')->directory('customer_avatar'),
                        Forms\Components\select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'active',
                                'not_active' => 'Non-Active'
                            ])
                    ])->columnSpan(4)
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_identitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('telp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('edit-password')
                    ->label('Change Password')
                    ->icon('heroicon-o-key')
                    ->action(function (Customer $record, array $data): void {
                        $record->update([
                            'password' => Hash::make($data['password']),
                        ]);
                    })
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->same('password_confirmation'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required()
                            ->minLength(8),
                    ])
                    ->modalHeading('Change Password')
                    ->modalButton('Save')
                    ->modalWidth('lg')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextEntry::make('no_identitas')
                                    ->copyable(),
                                TextEntry::make('nama_lengkap'),
                            ]),
                        Grid::make()
                            ->schema([
                                TextEntry::make('email'),
                                TextEntry::make('alamat'),
                            ]),
                        Grid::make()
                            ->schema([
                                TextEntry::make('telp'),

                            ]),
                    ])->columnSpan(8),
                Grid::make()
                    ->schema([
                        ImageEntry::make('avatar')
                            ->circular()
                            ->label('')
                            ->columnSpan(2)
                            ->defaultImageUrl(url('storage\customer_avatar\avatardefault.png'))
                            ->columnStart(2),
                        TextEntry::make('status')
                            ->badge()
                            ->label('')
                            ->alignCenter()
                            ->columnSpan(8)
                            ->color(fn (string $state): string => match ($state) {
                                'active' => 'success',
                                'non-active' => 'gray',
                            })

                    ])->columnSpan(4),
            ])->columns(12);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
