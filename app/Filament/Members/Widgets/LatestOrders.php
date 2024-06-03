<?php

namespace App\Filament\Members\Widgets;

use App\Filament\Members\Pages\EditProfile;
use Filament\Tables;
use App\Models\Customer;
use App\Models\Reservasi;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn\TextColumnSize;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Reservasi::query()->where("customer_id", auth()->user()->id)
            )
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
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn (Reservasi $record): string => route('invoice.show', ['invoice' => $record->kode_transaksi])),
            ]);
    }
}
