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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            $latestTransaksi = self::latest()->first();
            $newId = $latestTransaksi ? $latestTransaksi->id + 1 : 1;

            // Generate kode_transaksi
            $transaksi->kode_transaksi = $newId . mt_rand(100, 9999);
        });
    }

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
