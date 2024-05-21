<?php

namespace App\Filament\Resources\ReservasiResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ReservasiResource;

class EditReservasi extends EditRecord
{
    protected static string $resource = ReservasiResource::class;
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($data['status_reservasi'] == 'ditolak') {
            $data['status_pembayaran'] = 'refund';
            $record->update($data);
            return $record;
        } else {
            $record->update($data);
            return $record;
        }
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
