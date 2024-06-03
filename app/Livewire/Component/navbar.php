<?php

namespace App\Livewire\Component;

use App\Models\Mobil;
use Livewire\Component;
use Livewire\Attributes\On;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $isLoggedIn;

    public function mount()
    {
        $this->isLoggedIn = Auth::guard('members')->user();
    }

    #[On('handleLoginSuccess')]
    public function handleLoginSuccess()
    {
        $this->isLoggedIn = Auth::guard('members')->user();
    }

    public function render()
    {
        return view('livewire.component.navbar');
    }
}
