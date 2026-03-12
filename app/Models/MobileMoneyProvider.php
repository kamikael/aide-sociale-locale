<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MobileMoneyProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
         'code',
        'api_base_url',
        'country_iso',
        'is_active',
    ];

    protected $casts = [
        'name' => 'string',
        'api_base_url' => 'string',
    ];

    /**
     * Relation : 1 Provider → N Paiements
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class, 'provider_id');
    }

     public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
