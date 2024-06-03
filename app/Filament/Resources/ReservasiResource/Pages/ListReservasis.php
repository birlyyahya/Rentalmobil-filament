<?php

namespace App\Filament\Resources\ReservasiResource\Pages;

use Filament\Actions;
use App\Models\Reservasi;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReservasiResource;

class ListReservasis extends ListRecords
{
    protected static string $resource = ReservasiResource::class;
    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'New' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_reservasi', 'menunggu'))
                ->badge(Reservasi::query()->where('status_reservasi', 'menunggu')->count())
                ->badgeColor('info'),
            'On Process' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_reservasi', 'diproses'))
                ->badge(Reservasi::query()->where('status_reservasi', 'diproses')->count())
                ->badgeColor('warning'),
            'Accepted' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_reservasi', 'diterima'))
                ->badge(Reservasi::query()->where('status_reservasi', 'diterima')->count())
                ->badgeColor('success'),
            'Cancelled' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_reservasi', 'dibatalkan')->orWhere('status_reservasi','ditolak')->count())
                ->badge(Reservasi::query()->where('status_reservasi', 'dibatalkan')->orWhere('status_reservasi','ditolak')->count())
                ->badgeColor('danger'),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            ReservasiResource\Widgets\ReservasiOverview::class,
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
