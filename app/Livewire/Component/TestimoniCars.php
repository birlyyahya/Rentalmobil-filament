<?php

namespace App\Livewire\Component;

use App\Models\Mobil;
use Livewire\Component;

class TestimoniCars extends Component
{
    public $review;
    public function render()
    {
        return view('livewire.component.testimoni-cars');
    }
}
