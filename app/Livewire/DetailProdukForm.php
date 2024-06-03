<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Mobil;
use Livewire\Component;
use Livewire\Attributes\Validate;

class DetailProdukForm extends Component
{

    #[Validate('required')]
    public $keyword;

    #[Validate('required')]
    public $mobils;
    public function submit()
    {
        $this->validate();

        $tanggalAmbil = Carbon::createFromFormat("M d, Y H:i", $this->keyword['tanggalAmbil'] . " " . $this->keyword['waktu'])->format("Y-m-d H:i:s");
        $tanggalKembali = Carbon::createFromFormat("M d, Y H:i", $this->keyword['tanggalKembali'] . " " . $this->keyword['waktu'])->format("Y-m-d H:i:s");

        session(['keyword' => $this->keyword,'tanggalAmbil' => $tanggalAmbil,'tanggalKembali' => $tanggalKembali,'mobil' => $this->mobils]);

        return $this->redirect('/reservasi');

    }
    public function render()
    {
        return view('livewire.detail-produk-form');
    }
}
