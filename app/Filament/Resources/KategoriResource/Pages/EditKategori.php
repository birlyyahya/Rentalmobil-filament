<?php

namespace App\Filament\Resources\KategoriResource\Pages;

use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\KategoriResource;

class EditKategori extends EditRecord
{
    protected static string $resource = KategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
