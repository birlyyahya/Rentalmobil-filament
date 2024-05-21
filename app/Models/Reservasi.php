<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'Reservasis';
    protected $fillable = [
        'customer_id',
        'kode_transaksi',
        'total_bayar',
        'status_reservasi',
        'status_pembayaran',
        'keterangan',
    ];

    public function getKeteranganAttribute($value)
    {
        return json_decode($value, true);
    }
    public function setKeteranganAttribute($value)
    {
        $this->attributes['keterangan'] = json_encode($value);
    }
    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function reservasi_details()
    {
        return $this->hasOne(Reservasi_detail::class);
    }
}
