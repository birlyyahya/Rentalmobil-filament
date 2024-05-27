<?php

namespace App\Livewire\Homepage;

use App\Models\Mobil;
use Livewire\Component;

class Testimonial extends Component
{
    public $mobil;
    public function mount()
    {
        $this->mobil = Mobil::latest()->get();
    }
    public function render()
    {
        return view('livewire.homepage.testimonial');
    }
}
