<?php

namespace App\Livewire\Component;

use App\Models\Mobil;
use Livewire\Component;

class GalleryCars extends Component
{
    public $mobil;
    public function render()
    {
        return view('livewire.component.galleri-cars');
    }
}
