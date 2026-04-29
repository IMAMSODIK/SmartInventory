<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }

    public function profileUsaha(): BelongsTo{
        return $this->belongsTo(ProfileUsaha::class);
    }

    public function fotoProduk(): HasMany{
        return $this->hasMany(FotoProduk::class);
    }

    public function orderItem(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function itemKeranjang(): HasMany{
        return $this->hasMany(ItemKeranjang::class);
    }
}
