<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Mobil;
use App\Models\Customer;
use Filament\Forms\Form;
use App\Models\Reservasi;
use App\Models\Testimoni;
use Filament\Tables\Table;
use App\Models\Reservasi_detail;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Split;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\Entries\RatingEntry;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use App\Filament\Resources\TestimoniResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestimoniResource\RelationManagers;
use App\Filament\Resources\ReservasiResource\Widgets\ReservasiOverview;

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
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'nama_lengkap')
                    ->options(function () {
                        return Customer::whereIn('id', Reservasi::pluck('customer_id'))
                            ->pluck('nama_lengkap', 'id');
                    })
                    ->required()
                    ->reactive() // Tambahkan ini untuk memicu perubahan saat customer dipilih
                    ->afterStateUpdated(fn ($set) => $set('mobil_id', null)), // Reset mobil_id ketika customer berubah

                Forms\Components\Select::make('mobil_id')
                    ->label('Mobil')
                    ->options(function ($get) {
                        $customerId = $get('customer_id');
                        if ($customerId) {
                            return Mobil::whereIn('id', Reservasi_detail::whereHas('reservasi', function ($query) use ($customerId) {
                                $query->where('customer_id', $customerId);
                            })->pluck('mobil_id'))
                                ->pluck('nama_mobil', 'id');
                        }
                        return Mobil::pluck('nama_mobil', 'id'); // Default jika tidak ada customer yang dipilih
                    })
                    ->required(),
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
                    ->searchable()
                    ->limit(30),
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
