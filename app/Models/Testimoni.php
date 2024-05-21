<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'Testimonis';

    protected $fillable = [
        'customer_id',
        'mobil_id',
        'rating',
        'keterangan',
    ];


    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function Mobil()
    {
        return $this->belongsTo(Mobil::class);
    }
}
