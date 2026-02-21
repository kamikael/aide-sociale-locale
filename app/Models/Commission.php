<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'paiement_id',
        'amount',
        'rate_percentage',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'rate_percentage' => 'decimal:2',
    ];

    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class);
    }
}