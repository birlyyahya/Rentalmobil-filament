<?php

namespace App\Filament\Resources\MobilResource\Pages;

use App\Models\Mobil;
use Filament\Actions;
use App\Models\galleri;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MobilResource;
use Filament\Infolists\Components\ImageEntry;

class EditMobil extends EditRecord
{
    protected static string $resource = MobilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }


    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Asumsi $data['id'] adalah ID mobil saat ini
        $mobilId = $data['id'];

        // Ambil data mobil beserta galerinya
        $mobil = Mobil::with('galleri')->find($mobilId);

        // Ambil caption dari galeri yang berelasi
        $captions = $mobil->galleri->pluck('caption')->first();
        $image = $mobil->galleri->pluck('image');

        // Tambahkan captions ke dalam data
        $data['caption'] = $captions;
        $data['galleri'] = $image;

        return $data;
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        $hasil = galleri::where('mobil_id', $record->id)
            ->whereNotIn('image', $data['galleri'])
            ->get();

        if ($hasil) {
            $hasil->each(function ($gambar) {
                $path = public_path('storage/' . $gambar->image);
                if (File::exists($path)) {
                    File::delete($path); // Menghapus gambar dari lokal
                }
                $gambar->delete();
            });
        };

        foreach ($data['galleri'] as $gambar) {
            // Mengecek apakah gambar sudah ada dalam record
            $galleri = galleri::firstOrNew(['mobil_id' => $record->id, 'image' => $gambar]);
            $galleri->caption = $data['caption'];
            $galleri->save();
        }

        // Debugging output
        return $record;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
