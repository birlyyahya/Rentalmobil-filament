<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mobil extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'Mobils';

    protected $fillable = [
        'nama_mobil',
        'kategori_id',
        'kapasitas',
        'warna',
        'transmisi',
        'jenis_bbm',
        'deskripsi',
        'harga_sewa',
        'status',
    ];

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class)->withTrashed()->withDefault();
    }
    function galleri()
    {
        return $this->hasMany(Galleri::class);
    }
    public function Reservasi_detail()
    {
        return $this->hasMany(Reservasi_detail::class);
    }
    public function Testimoni()
    {
        return $this->hasMany(Testimoni::class);
    }
}
