<?php

namespace App\Livewire\Component;

use App\Models\Mobil;
use Livewire\Component;

class FilterCars extends Component
{
    public $mobil;
    public function render()
    {
        return view('livewire.component.filter-cars');
    }
}
