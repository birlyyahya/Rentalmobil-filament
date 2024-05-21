<?php

namespace App\Models;

use Filament\Panel;
use Spatie\Color\Rgb;
use Filament\Facades\Filament;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\HasAvatar;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\SoftDeletes;
use Filament\AvatarProviders\UiAvatarsProvider;
use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Customer extends Model implements AuthenticatableContract
{
    use HasFactory;
    use SoftDeletes;
    use Authenticatable;


    protected $table = 'Customers';

    protected $fillable = [
        'no_identitas',
        'jenis_identitas',
        'nama_lengkap',
        'email',
        'alamat',
        'telp',
        'password',
        'avatar',
        'status',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function Reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }
    public function Testimoni()
    {
        return $this->hasMany(Testimoni::class);
    }

    public function authenticatemember($value)
    {
        return $this->where('id', $value['id'])->first();
    }

    public function canAccessPanel(Panel $panel): bool
    {

        if ($panel->getId() === 'members') {
            return str_ends_with($this->email, '@yourdomain.com');
        }

        return true;
    }
}
