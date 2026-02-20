<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cagnotte extends Model
{

use HasFactory;
    protected $fillable = [
        'organisateur_id',
        'title',
        'description',
        'image_path',
        'video_url',
        'target_amount',
        'collected_amount',
        'status',
        'published_at',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'published_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function organisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organisateur_id');
    }

    public function dons(): HasMany
    {
        return $this->hasMany(Don::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor : progression %
    |--------------------------------------------------------------------------
    */

    public function getProgressAttribute(): float
    {
        if ($this->target_amount == 0) {
            return 0;
        }

        return min(
            round(($this->collected_amount / $this->target_amount) * 100, 2),
            100
        );
    }
}
