<?php

namespace App\Filament\Resources\MobilResource\Pages;

use App\Models\Mobil;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Group;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\MobilResource;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Split as ComponentsSplit;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;

class ViewMobil extends ViewRecord
{
    protected static string $resource = MobilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make([
                    ComponentsSplit::make([
                        Group::make([
                            TextEntry::make('nama_mobil'),
                            TextEntry::make('kapasitas')
                                ->suffix(' Seats'),
                            TextEntry::make('jenis_bbm'),
                            TextEntry::make('harga_sewa')
                                ->money('IDR'),
                        ]),
                        Group::make([
                            TextEntry::make('kategori.kategori_mobil'),
                            ColorEntry::make('warna'),
                            TextEntry::make('transmisi'),
                        ]),
                        Group::make([
                            ImageEntry::make('galleri.image')
                                ->limit(3)
                                ->label('Featured Image')
                                ->size(150)
                                ->stacked(),
                        ]),
                    ]),
                ]),
                Section::make([
                    TextEntry::make('deskripsi')
                        ->label(''),
                ])->heading('Content'),

            ]);
    }
}
