<?php

namespace App\Livewire\Component;

use App\Models\Mobil;
use Livewire\Component;

class FilterCars extends Component
{
    public $mobil;
    public $mobilAwal;
    public $keyword;
    public $filterColumn = 'kategori_mobil';
    public $filterValue = [];
    public $filterKapasitas = [];
    public $filterBbm = [];
    public $filterTransmisi = [];

    public function mount()
    {
        $this->mobilAwal = collect($this->mobil);
    }
    public function render()
    {
        return view('livewire.component.filter-cars');
    }

    public function getCategoryCars()
    {
        $allMobil = collect($this->mobilAwal);

        $filteredMobil = $allMobil->filter(function ($mobil) {
            $kategoriMatch = empty($this->filterValue) || !empty(array_intersect([$mobil->kategori->kategori_mobil], $this->filterValue));
            $kapasitasMatch = empty($this->filterKapasitas) || !empty(array_intersect([$mobil->kapasitas], $this->filterKapasitas));
            $bbmMatch = empty($this->filterBbm) || !empty(array_intersect([$mobil->jenis_bbm], $this->filterBbm));
            $transmisiMatch = empty($this->filterTransmisi) || !empty(array_intersect([$mobil->transmisi], $this->filterTransmisi));

            return $kategoriMatch && $kapasitasMatch && $bbmMatch && $transmisiMatch;
        });

        $this->mobil = $filteredMobil->all();
    }

    // public function updatedFilterValue()
    // {
    //     $this->getCategoryCars(); // Memanggil fungsi setiap kali filterValue diupdate
    // }

}
