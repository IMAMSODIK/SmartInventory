<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function buyer(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function profileUsaha(): BelongsTo{
        return $this->belongsTo(ProfileUsaha::class);
    }

    public function alamat(): BelongsTo{
        return $this->belongsTo(Alamat::class);
    }

    public function orderItem(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function pengiriman(): HasOne{
        return $this->hasOne(Pengiriman::class);
    }
}
