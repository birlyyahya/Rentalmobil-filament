<?php

namespace App\Livewire\Homepage;

use App\Models\Mobil;
use Livewire\Component;

class MobilOfferToday extends Component
{
    public $mobil;
    public function mount(){
        $this->mobil = Mobil::whereNotIn('status',['away','booked   '])->get();
    }
    public function render()
    {
        return view('livewire.homepage.mobil-offer-today');
    }
}
