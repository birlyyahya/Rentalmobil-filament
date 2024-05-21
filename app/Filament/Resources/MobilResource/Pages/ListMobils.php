<?php

namespace App\Filament\Resources\MobilResource\Pages;

use App\Models\Mobil;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\MobilResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMobils extends ListRecords
{
    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Ready' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'ready'))
                ->badge(Mobil::query()->where('status', 'ready')->count())
                ->badgeColor('info'),
            'Away' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'away'))
                ->badge(Mobil::query()->where('status', 'away')->count())
                ->badgeColor('info'),
            'Booked Today' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'booked'))
                ->badge(Mobil::query()->where('status', 'booked')->count())
                ->badgeColor('info'),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            MobilResource\Widgets\MobilOverview::class,
        ];
    }
    protected static string $resource = MobilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
