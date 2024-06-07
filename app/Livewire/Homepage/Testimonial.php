<?php

namespace App\Livewire\Homepage;

use App\Models\Testimoni;
use Livewire\Component;

class Testimonial extends Component
{
    public $testi;
    public function mount()
    {
        $this->testi = Testimoni::where('rating','5')->orWhere('rating','3')->orWhere('rating','4')->get();
    }
    public function render()
    {
        return view('livewire.homepage.testimonial');
    }
}
