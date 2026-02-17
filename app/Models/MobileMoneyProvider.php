<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MobileMoneyProvider extends Model
{
    protected $table = 'mobile_money_providers';

    protected $fillable = [
        'nom',
        'code',
        'api_url',
        'api_key',
        'api_secret',
        'sandbox',
        'credentials',
    ];

    protected $casts = [
        'sandbox' => 'boolean',
        'credentials' => 'array',
    ];

    protected $hidden = [
        'api_key',
        'api_secret',
        'credentials',
    ];

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class, 'mobile_money_provider_id');
    }

    public function getApiCredentials(): array
    {
        return array_filter([
            'api_key' => $this->api_key,
            'api_secret' => $this->api_secret,
            ...($this->credentials ?? []),
        ]);
    }
}
