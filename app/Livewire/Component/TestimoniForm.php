<?php

namespace App\Livewire\Component;

use App\Models\Mobil;
use App\Models\Testimoni;
use Livewire\Component;

class TestimoniForm extends Component
{
    public $customer;
    public $id;
    public $review;
    public $rating = 0;
    public $message = false;
    public $cekDataTestimoni;
    protected $rules = [
        'review' => 'string|max:500',
    ];

    public function mount()
    {
        $cekDataTestimoni = Testimoni::where('customer_id', $this->customer->id)->where('mobil_id', $this->id)->get()->first();

        if (!empty($cekDataTestimoni)) {
            $this->review = $cekDataTestimoni['keterangan'];
            $this->rating = $cekDataTestimoni['rating'];
            $this->cekDataTestimoni = $cekDataTestimoni['updated_at'];
        } else {
            return;
        }

        date_default_timezone_set('asia/jakarta');
    }
    public function render()
    {
        return view('livewire.component.testimoni-form');
    }
    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function save()
    {
        $this->validate();

        if ($this->cekDataTestimoni !== NULL) {

            Testimoni::where('customer_id', $this->customer->id)
                ->where('mobil_id', $this->id)
                ->update([
                    'rating' => $this->rating,
                    'keterangan' => $this->review,
                ]);
                $this->message = true;
        }else {

            Testimoni::create([
                'customer_id' => $this->customer->id,
                'mobil_id' => $this->id,
                'rating' => $this->rating,
                'keterangan' => $this->review,
            ]);

            $this->message = true;
        }
    }
}
