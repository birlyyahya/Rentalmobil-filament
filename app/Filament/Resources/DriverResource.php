<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationGroup = 'Orders';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Group::make([
                        Forms\Components\TextInput::make('nama_driver')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telp')
                            ->tel()
                            ->required()
                            ->maxLength(14),
                    ]),
                ])->columnSpan(8),
                Section::make([
                    Forms\Components\FileUpload::make('avatar')
                        ->image()
                        ->label('')
                        ->circleCropper()
                        ->alignCenter()
                        ->imageEditor()
                        ->disk('public')->directory('driver_avatar')
                        ->avatar(),
                    Forms\Components\Select::make('status')
                        ->required()
                        ->options([
                            'ready' => 'Ready',
                            'away' => 'Away',
                            'booked' => 'Booked',
                        ])
                        ->default('ready')
                        ->selectablePlaceholder(false),
                ])->columnSpan(4)
                    ->heading('Avatar Featured'),
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_driver')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telp')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'ready' => 'Ready',
                        'away' => 'Away',
                        'booked' => 'Booked',
                    ])
                    ->selectablePlaceholder(false)
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
