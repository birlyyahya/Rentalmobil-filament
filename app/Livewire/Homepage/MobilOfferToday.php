<?php

namespace App\Livewire\Homepage;

use Carbon\Carbon;
use App\Models\Mobil;
use Livewire\Component;

class MobilOfferToday extends Component
{
    public $mobil;
    public $tanggalAmbil;
    public $tanggalKembali;
    public $waktu;
    public function mount(){
        $this->mobil = Mobil::with('galleri')->whereNotIn('status',['away','booked'])->get();
        $this->tanggalAmbil = Carbon::now()->format('d m Y');
        $this->tanggalKembali = Carbon::now()->addDay()->format('d m Y'); // Add 1 day
        $this->waktu = Carbon::now()->format('H:i');

    }
    public function render()
    {
        return view('livewire.homepage.mobil-offer-today');
    }
}
