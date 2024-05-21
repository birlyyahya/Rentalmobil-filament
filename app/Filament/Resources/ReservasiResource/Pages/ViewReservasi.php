<?php

namespace App\Filament\Resources\ReservasiResource\Pages;

use App\Filament\Resources\ReservasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReservasi extends ViewRecord
{
    protected static string $resource = ReservasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
