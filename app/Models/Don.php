<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Don extends Model
{
    protected $table = 'dons';

    protected $fillable = [
        'utilisateur_id',
        'montant',
        'statut',
        'reference_externe',
        'paye_at',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'paye_at' => 'datetime',
    ];

    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_COMPLETE = 'complete';
    public const STATUT_ECHOUE = 'echoue';
    public const STATUT_REMBOURSE = 'rembourse';

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class, 'don_id');
    }

    public function commission(): HasOne
    {
        return $this->hasOne(Commission::class, 'don_id');
    }

    public function isPaye(): bool
    {
        return $this->statut === self::STATUT_COMPLETE;
    }
}
