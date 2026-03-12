<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{

use HasFactory;
    protected $fillable = [
        'user_id',
        'cagnotte_id',
        'provider_id',
        'transaction_reference',
        'montant',
        'commission_amount',
        'status',
        'paid_at',
        'phone_number',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(MobileMoneyProvider::class, 'provider_id');
    }

    public function don(): HasOne
    {
        return $this->hasOne(Don::class);
    }

    public function commission(): HasOne
    {
        return $this->hasOne(Commission::class);
    }
}
