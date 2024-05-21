<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\AvatarProviders\UiAvatarsProvider;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'Drivers';

    protected $fillable = [
        'nama_driver',
        'telp',
        'avatar',
        'status',

    ];

    public function Reservasi_detail()
    {
        return $this->hasMany(Reservasi_detail::class);
    }
}
