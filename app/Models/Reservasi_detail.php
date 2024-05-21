<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi_detail extends Model
{
    use HasFactory;

    protected $table = 'reservasi_details';
    protected $fillable = [
        'reservasi_id',
        'mobil_id',
        'driver_id',
        'tanggal_ambil',
        'tanggal_kembali',
        'durasi_sewa',
        'tujuan',
        'biaya_sewa',
        'biaya_driver',
        'status_pengembalian',
    ];

    public function Reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }
    public function Mobil()
    {
        return $this->belongsTo(Mobil::class)->withDefault();
    }
    public function Driver()
    {
        return $this->belongsTo(Driver::class)->withDefault();
    }
}
