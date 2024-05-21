<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'Kategoris';
    protected $fillable = ['kategori_mobil', 'kategori_slug', 'deskripsi_kategori'];

    public function Mobil()
    {
        return $this->hasMany(Mobil::class);
    }
    // Scope untuk mengambil kategori yang tidak dihapus
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
