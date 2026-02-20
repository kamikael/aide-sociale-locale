<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Don extends Model
{
use HasFactory;

    protected $fillable = [
        'donateur_id',
        'cagnotte_id',
        'paiement_id',
        'montant',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    public function donateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donateur_id');
    }

    public function cagnotte(): BelongsTo
    {
        return $this->belongsTo(Cagnotte::class);
    }

    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class);
    }
}
