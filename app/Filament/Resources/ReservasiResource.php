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
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
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
                        'dibatalkan' => 'Dibatalkan',
                    ])
                    ->colors([
                        'menunggu' => 'info',
                        'diproses' => 'warning',
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                        'dibatalkan' => 'danger',
                    ])
                    ->icons([
                        'menunggu' => 'heroicon-c-sparkles',
                        'diproses' => 'heroicon-c-arrow-path',
                        'diterima' => 'heroicon-c-check-circle',
                        'ditolak' => 'heroicon-m-x-circle',
                        'dibatalkan' => 'heroicon-m-x-circle',
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
                Forms\Components\Textarea::make('keterangan')
                    ->required()
                    ->rows(6)
                    ->cols(10)
                    ->formatStateUsing(function ($state) {
                        $keterangan = json_decode($state, true);
                        if ($keterangan == !NULL) {
                            return $keterangan['type'] . '-' . $keterangan['number'] . ',' . $keterangan['name'] . ' ' . $keterangan['expirationDate'];
                        } else {
                            return $state;
                        }
                    }),
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
                    ->sortable()
                    ->searchable(),
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
                        'dibatalkan' => 'danger',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'menunggu' => 'heroicon-c-sparkles',
                        'diproses' => 'heroicon-c-arrow-path',
                        'diterima' => 'heroicon-c-check-circle',
                        'ditolak' => 'heroicon-m-x-circle',
                        'dibatalkan' => 'heroicon-m-x-circle',
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable()
                    ->wrap()
                    ->formatStateUsing(function (string $state): string {
                        // Split the state by comma to get individual entries
                        $entries = explode(',', $state);

                        // Initialize an array to hold formatted entries
                        $formattedEntries = [];

                        // Process each entry
                        foreach ($entries as $entry) {
                            // Trim any extra whitespace
                            $entry = trim($entry);

                            // Replace colon with ': ' for better readability
                            $entry = str_replace(':', ': ', $entry);

                            // Add the formatted entry to the array
                            $formattedEntries[] = '• ' . $entry;
                        }

                        // Join the formatted entries with a new line for each entry
                        return implode("\n", $formattedEntries);
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
                    FilamentExportBulkAction::make('Export')
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
