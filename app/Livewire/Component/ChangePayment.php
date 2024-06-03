<?php

namespace App\Livewire\Component;

use App\Models\Reservasi as ModelsReservasi;
use Livewire\Component;

class ChangePayment extends Component
{
    public $paymentMethod;
    public $id;

    public $status;
    public $payment;
    public function submitForm()
    {
        // Lakukan validasi data input jika diperlukan
        $this->validate([
            'paymentMethod' => 'required',
        ]);

        $reservasi = ModelsReservasi::find($this->id);

        $reservasi->update([
            'keterangan' => 'pay:' . $this->paymentMethod,
        ]);


        $this->payment = $this->paymentMethod;

        $this->js('window.location.reload()');
    }
    public function render()
    {
        return view('livewire.component.modal-changepayment');
    }
}
