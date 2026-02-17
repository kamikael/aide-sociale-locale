<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'don_id',
        'mobile_money_provider_id',
        'montant',
        'statut',
        'reference_provider',
        'provider',
        'metadata',
        'paye_at',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'metadata' => 'array',
        'paye_at' => 'datetime',
    ];

    public const STATUT_INITIE = 'initie';
    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_REUSSI = 'reussi';
    public const STATUT_ECHOUE = 'echoue';
    public const STATUT_REMBOURSE = 'rembourse';

    public function don(): BelongsTo
    {
        return $this->belongsTo(Don::class, 'don_id');
    }

    public function mobileMoneyProvider(): BelongsTo
    {
        return $this->belongsTo(MobileMoneyProvider::class, 'mobile_money_provider_id');
    }

    public function isReussi(): bool
    {
        return $this->statut === self::STATUT_REUSSI;
    }
}
