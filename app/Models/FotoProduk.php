<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoProduk extends Model
{
    /** @use HasFactory<\Database\Factories\FotoProdukFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function produk(): BelongsTo{
        return $this->belongsTo(Produk::class);
    }
}
