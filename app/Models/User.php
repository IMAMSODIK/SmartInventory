<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function alamat(): HasMany{
        return $this->hasMany(Alamat::class);
    }

    public function order(): HasMany{
        return $this->hasMany(Order::class);
    }

    public function keranjang(): HasMany{
        return $this->hasMany(Keranjang::class);
    }

    public function profileUsaha(): HasOne{
        return $this->hasOne(ProfileUsaha::class);
    }

    public function driver(): HasOne{
        return $this->hasOne(Driver::class);
    }

    public function pengiriman(): HasMany{
        return $this->hasMany(Pengiriman::class);
    }

    public function dompet(): HasOne{
        return $this->hasOne(Dompet::class);
    }

    public function withdrawals(): HasMany{
        return $this->hasMany(Withdrawals::class);
    }
}
