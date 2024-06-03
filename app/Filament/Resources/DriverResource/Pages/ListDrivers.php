<?php

namespace App\Filament\Resources\DriverResource\Pages;

use App\Filament\Resources\DriverResource;
use App\Models\Driver;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListDrivers extends ListRecords
{
    protected static string $resource = DriverResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Ready' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'ready'))
                ->badge(Driver::query()->where('status', 'ready')->count())
                ->badgeColor('info'),
            'Away' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'away'))
                ->badge(Driver::query()->where('status', 'away')->count())
                ->badgeColor('info'),
            'Booked Today' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'booked'))
                ->badge(Driver::query()->where('status', 'booked')->count())
                ->badgeColor('info'),
        ];
    }
}
