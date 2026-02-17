<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cagnotte extends Model
{
    protected $table = 'cagnottes';

    protected $fillable = [
        'titre',
        'slug',
        'description',
        'objectif',
        'montant_collecte',
        'active',
    ];

    protected $casts = [
        'objectif' => 'decimal:2',
        'montant_collecte' => 'decimal:2',
        'active' => 'boolean',
    ];

    public static function booted(): void
    {
        static::creating(function (Cagnotte $cagnotte) {
            if (empty($cagnotte->slug)) {
                $cagnotte->slug = Str::slug($cagnotte->titre);
            }
        });
    }

    public function getPourcentageAttribute(): float
    {
        if ($this->objectif <= 0) {
            return 0.0;
        }
        return min(100, round((float) $this->montant_collecte / (float) $this->objectif * 100, 2));
    }
}
