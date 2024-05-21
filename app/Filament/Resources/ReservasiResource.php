<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Customer;
use Filament\Forms\Form;
use App\Models\Reservasi;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReservasiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use App\Filament\Resources\ReservasiDetailsResource\RelationManagers;
use App\Filament\Resources\ReservasiResource\RelationManagers\ReservasiDetailsRelationManager;

class ReservasiResource extends Resource
{
    protected static ?string $model = Reservasi::class;

    protected static ?string $pluralLabel = 'Reservasi';
    protected static ?string $navigationLabel = 'Reservasi';

    protected static ?string $navigationGroup = 'Orders';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status_reservasi', 'menunggu')->count();
    }
    public static function getWidgets(): array
    {
        return [
            ReservasiResource\Widgets\ReservasiOverview::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_transaksi')
                    ->required()
                    ->label('Kode Transaksi')
                    ->disabled(),
                Forms\Components\Select::make('customer.id')
                    ->relationship('customer', 'nama_lengkap')
                    ->options(Customer::pluck('nama_lengkap', 'id'))
                    ->required(),

                Forms\Components\TextInput::make('total_bayar')
                    ->required()
                    ->numeric(),
                Forms\Components\ToggleButtons::make('status_reservasi')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'diproses' => 'Diproses',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->colors([
                        'menunggu' => 'info',
                        'diproses' => 'warning',
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                    ])
                    ->icons([
                        'menunggu' => 'heroicon-c-sparkles',
                        'diproses' => 'heroicon-c-arrow-path',
                        'diterima' => 'heroicon-c-check-circle',
                        'ditolak' => 'heroicon-m-x-circle',
                    ])
                    ->inline(),
                Forms\Components\Select::make('status_pembayaran')
                    ->options([
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                        'expired' => 'Expired',
                        'refund' => 'Refund',
                    ])
                    ->selectablePlaceholder(false),
                Forms\Components\TextInput::make('keterangan')
                    ->required()
                    ->formatStateUsing(function ($state) {
                        $keterangan = json_decode($state, true);
                        if ($keterangan == !NULL) {
                            return $keterangan['type'] . '-' . $keterangan['number'] . ',' . $keterangan['name'] . ' ' . $keterangan['expirationDate'];
                        } else {
                            return $state;
                        }
                    })
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Manage Orders')
            ->description('Manage your orders here.')
            ->columns([
                Tables\Columns\TextColumn::make('kode_transaksi')
                    ->label('Invoice #')
                    ->formatStateUsing(
                        function ($state) {
                            return 'Invoice #' . $state;
                        }
                    )
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.nama_lengkap')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_reservasi')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return ucwords($state);
                    })
                    ->size(TextColumnSize::Large)
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'info',
                        'diproses' => 'warning',
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'menunggu' => 'heroicon-c-sparkles',
                        'diproses' => 'heroicon-c-arrow-path',
                        'diterima' => 'heroicon-c-check-circle',
                        'ditolak' => 'heroicon-m-x-circle',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return Str::upper($state);
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'danger',
                        'expired' => 'gray',
                        'refund' => 'warning',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_bayar')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable()
                    ->limit(30)
                    ->formatStateUsing(function ($state) {

                        $keterangan = json_decode($state, true);
                        if ($keterangan == !NULL) {
                            return $keterangan['type'] . '-' . $keterangan['number'] . ',' . $keterangan['name'] . ' ' . $keterangan['expirationDate'];
                        } else {
                            return $state;
                        }
                    }),
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
                Tables\Actions\EditAction::make(),
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
            ReservasiDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservasis::route('/'),
            'create' => Pages\CreateReservasi::route('/create'),
            'view' => Pages\ViewReservasi::route('/{record}'),
            'edit' => Pages\EditReservasi::route('/{record}/edit'),
        ];
    }
}
