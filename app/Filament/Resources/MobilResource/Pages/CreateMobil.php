<?php

namespace App\Filament\Resources\MobilResource\Pages;

use App\Models\Mobil;
use Filament\Actions;
use App\Models\galleri;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Unset_;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\MobilResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMobil extends CreateRecord
{


    protected static string $resource = MobilResource::class;


    protected function handleRecordCreation(array $data): Model
    {
        $data['harga_sewa'] = Str::remove(',', $data['harga_sewa']);
        $record = static::getModel()::create($data);


        foreach ($data['galleri'] as $gambar) {
            $galleri = new galleri();
            $galleri->mobil_id = $record->id;
            $galleri->caption = $data['caption'];
            $galleri->image = $gambar;
            // Pindahkan file ke path yang ditentukan
            $galleri->save();
        }
        return $record;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
