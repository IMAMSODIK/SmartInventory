<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawals extends Model
{
    /** @use HasFactory<\Database\Factories\WithdrawalsFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
