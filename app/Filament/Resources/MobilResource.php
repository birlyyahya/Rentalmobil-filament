<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Mobil;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MobilResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class MobilResource extends Resource
{

    protected static ?string $model = Mobil::class;

    protected static ?string $pluralLabel = 'Mobil';
    protected static ?string $navigationLabel = 'Mobil';

    protected static ?string $navigationGroup = 'Cars Settings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getWidgets(): array
    {
        return [
            MobilResource\Widgets\MobilOverview::class,
        ];
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Split::make([
                        Forms\Components\TextInput::make('nama_mobil')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('kategori_id')
                            ->required()
                            ->relationship(name: 'kategori', titleAttribute: 'kategori_mobil')
                            ->options(
                                Kategori::active()->pluck('kategori_mobil', 'id')
                            )
                            ->placeholder('Pilih Kategori'),
                    ]),
                    Split::make([
                        Forms\Components\TextInput::make('kapasitas')
                            ->required()
                            ->integer()
                            ->suffix('Seats')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('warna')
                            ->required()
                            ->suffixIcon('heroicon-o-rectangle-stack')
                            ->maxLength(255),
                        Forms\Components\Select::make('jenis_bbm')
                            ->required()
                            ->selectablePlaceholder(false)
                            ->options([
                                'bensin' => 'Bensin',
                                'diesel' => 'Diesel',
                                'Solar' => 'Solar',
                                'electric' => 'Electric',
                                'hybrid' => 'hybrid',
                            ])
                            ->default('bensin'),
                        Forms\Components\Select::make('transmisi')
                            ->required()
                            ->selectablePlaceholder(false)
                            ->default('automatic')
                            ->options([
                                'automatic' => 'Automatic',
                                'manual' => 'Manual'
                            ]),
                    ]),
                    Forms\Components\Textarea::make('deskripsi')
                        ->required()
                        ->maxLength(255),
                    Split::make([
                        Forms\Components\TextInput::make('harga_sewa')
                            ->required()
                            ->prefix('Rp')
                            ->mask(RawJs::make(<<<'JS'
                             $money($input,'.')
                            JS)),
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                'ready' => 'Ready',
                                'Away' => 'Away'
                            ])
                            ->default('ready')
                            ->grow(false),
                    ]),
                ])->columnSpan(8),
                Section::make()
                    ->heading('Featured Image')
                    ->schema([
                        FileUpload::make('galleri')
                            ->multiple()
                            ->maxFiles(3)
                            ->reorderable()
                            ->disk('public')->directory('mobil_photo')
                            ->appendFiles()
                            ->openable()
                            ->imageEditor()
                            ->storeFileNamesIn('attachment_file_names'),
                        TextInput::make('caption'),
                    ])->columnSpan(4)
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_mobil')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori.kategori_mobil')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kapasitas')
                    ->searchable()
                    ->suffix(' Seats'),
                Tables\Columns\TextColumn::make('warna')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transmisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_bbm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga_sewa')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['harga_sewa'] = Str::remove(',', $data['biaya_sewa']);

                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListMobils::route('/'),
            'create' => Pages\CreateMobil::route('/create'),
            'view' => Pages\ViewMobil::route('/{record}'),
            'edit' => Pages\EditMobil::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
