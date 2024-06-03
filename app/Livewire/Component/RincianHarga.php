<?php

namespace App\Livewire\Component;

use App\Models\Mobil;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Route;
use Psy\Readline\Hoa\Console;

class RincianHarga extends Component
{
    public $mobil;
    public $pajak;
    public $totalPajak;
    public $CurrentURL;
    public $driver;



    public function mount()
    {
        $this->pajak = $this->mobil->harga_sewa * 0.11;
        $this->CurrentURL = Route::currentRouteName();
        $this->driver = ['driver' => false, 'harga' => 0, 'hari' => 0];
        $this->updateTotalPajak();
    }

    #[On('updatedDriver')]
    public function updatedDriver($countDay)
    {
        if ($this->driver['driver'] == false ) {
            $this->driver = ['driver' => true, 'harga' => 200000,'hari' => $countDay];
            $this->updateTotalPajak();
        } else {
            $this->driver = ['driver' => false, 'harga' => 0, 'hari' => 0];
            $this->totalPajak = $this->mobil->harga_sewa + $this->pajak;
        }
    }
    private function updateTotalPajak()
    {
        if ($this->driver['driver'] == false) {
            $this->totalPajak = $this->mobil->harga_sewa + $this->pajak;
            $this->dispatch('handleDataHarga', $this->totalPajak, $this->driver);
        } else {
            $tax = $this->mobil->harga_sewa + $this->driver['harga'];
            $this->pajak = $tax * 0.11;
            $this->totalPajak = $this->mobil->harga_sewa + $this->pajak + $this->driver['harga'];
            $this->dispatch('handleDataHarga', $this->totalPajak, $this->driver);
        }
    }

    private function getAlldata()
    {
        return 'hay';
    }

    public function render()
    {
        return view('livewire.component.rincian-harga');
    }
}
