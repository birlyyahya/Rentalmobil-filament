<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimoniResource\Pages;
use App\Filament\Resources\TestimoniResource\RelationManagers;
use App\Models\Testimoni;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\Entries\RatingEntry;

class TestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;

    protected static ?string $navigationLabel = 'Testimoni';

    protected static ?string $pluralLabel = 'Testimoni';

    protected static ?string $navigationGroup = 'Members';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('mobil')
                    ->disabled()
                    ->relationship(name: 'mobil', titleAttribute: 'nama_mobil'),
                Rating::make('rating')
                    ->required(),
                Forms\Components\RichEditor::make('keterangan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.nama_lengkap')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mobil.nama_mobil')
                    ->numeric()
                    ->sortable(),
                RatingColumn::make('rating')
                    ->stars(5)
                    ->color('warning'),
                Tables\Columns\TextColumn::make('keterangan')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
                Split::make([
                    ImageEntry::make('customer.avatar')
                        ->label('')
                        ->alignCenter()
                        ->columnSpan(0),
                    Group::make([
                        TextEntry::make('customer.nama_lengkap'),
                        TextEntry::make('mobil.nama_mobil'),
                    ])->columnSpan(1),
                ]),
                RatingEntry::make('rating')
                    ->columnStart(3),
                TextEntry::make('keterangan')
                    ->columnSpanFull(),
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
            'index' => Pages\ListTestimonis::route('/'),
            'create' => Pages\CreateTestimoni::route('/create'),
        ];
    }
}
