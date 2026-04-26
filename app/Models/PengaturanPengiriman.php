<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanPengiriman extends Model
{
    /** @use HasFactory<\Database\Factories\PengaturanPengirimanFactory> */
    use HasFactory;

    protected $guarded = ['id'];
}
