<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    protected $table = 'commissions';

    protected $fillable = [
        'don_id',
        'montant_commission',
    ];

    protected $casts = [
        'montant_commission' => 'decimal:2',
    ];

    public function don(): BelongsTo
    {
        return $this->belongsTo(Don::class, 'don_id');
    }
}
