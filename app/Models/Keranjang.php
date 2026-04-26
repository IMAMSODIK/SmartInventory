<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keranjang extends Model
{
    /** @use HasFactory<\Database\Factories\KeranjangFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function itemKeranjang(): HasMany{
        return $this->hasMany(ItemKeranjang::class);
    }
}
