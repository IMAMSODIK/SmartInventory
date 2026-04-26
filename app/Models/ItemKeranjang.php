<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemKeranjang extends Model
{
    /** @use HasFactory<\Database\Factories\ItemKeranjangFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function keranjang(): BelongsTo{
        return $this->belongsTo(Keranjang::class);
    }

    public function produk(): BelongsTo{
        return $this->belongsTo(Produk::class);
    }
}
