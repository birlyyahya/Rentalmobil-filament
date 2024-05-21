<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class galleri extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobil_id',
        'caption',
        'image',
    ];

    public function Mobil()
    {
        return $this->belongsTo(Mobil::class);
    }
}
