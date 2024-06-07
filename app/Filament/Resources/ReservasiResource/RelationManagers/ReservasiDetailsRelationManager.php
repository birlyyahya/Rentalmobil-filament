<?php

namespace App\Filament\Resources\ReservasiResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Mobil;
use App\Models\Driver;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ReservasiDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'reservasi_details';
    protected static ?string $title = 'Reservasi Detail';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mobil_id')
                    ->relationship('mobil', 'nama_mobil')
                    ->options(function () {
                        return Mobil::where('status', '!=', 'away')->pluck('nama_mobil', 'id');
                    }),
                Forms\Components\TextInput::make('tujuan')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_ambil')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_kembali')
                    ->required(),
                Forms\Components\TextInput::make('durasi_sewa')
                    ->suffix('Hari')
                    ->required(),
                Forms\Components\Select::make('driver_id')
                    ->relationship('driver', 'nama_driver')
                    ->options(function () {
                        return Driver::where('status', 'ready')->pluck('nama_driver', 'id');
                    }),
                Forms\Components\ToggleButtons::make('status_pengembalian')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'berjalan' => 'berjalan',
                        'kembali' => 'kembali',
                    ])
                    ->colors([
                        'menunggu' => 'info',
                        'berjalan' => 'berjalan',
                        'kembali' => 'kembali',
                    ])
                    ->icons([
                        'menunggu' => 'heroicon-c-sparkles',
                        'berjalan' => 'heroicon-c-arrow-path',
                        'kembali' => 'heroicon-c-check-circle',
                    ])
                    ->inline(),
                Forms\Components\TextInput::make('biaya_sewa')
                    ->prefix('Rp ')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('biaya_driver')
                    ->prefix('Rp ')
                    ->numeric()
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mobil.nama_mobil'),
                Tables\Columns\TextColumn::make('tanggal_ambil'),
                Tables\Columns\TextColumn::make('tanggal_kembali'),
                Tables\Columns\TextColumn::make('durasi_sewa')
                    ->suffix(' Hari'),
                Tables\Columns\TextColumn::make('biaya_sewa')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('biaya_driver')
                    ->money('IDR')
                    ->default('0'),
                Tables\Columns\TextColumn::make('status_pengembalian')
                    ->label('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'menunggu' => 'info',
                        'berjalan' => 'warning',
                        'kembali' => 'success',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create Reservasi Detail'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['biaya_sewa'] = Str::remove(',', $data['biaya_sewa']);
                        $data['biaya_driver'] = Str::remove(',', $data['biaya_driver']);

                        return $data;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }
}
