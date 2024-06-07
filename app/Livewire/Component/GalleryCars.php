<?php

namespace App\Livewire\Component;

use App\Models\galleri;
use App\Models\Mobil;
use Livewire\Component;

class GalleryCars extends Component
{
    public $id;

    public $galleri;

    function mount() {
        $this->galleri = galleri::where('mobil_id', $this->id)->get();
    }

    public function render()
    {
        return view('livewire.component.galleri-cars');
    }
}
