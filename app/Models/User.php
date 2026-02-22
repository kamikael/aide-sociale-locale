<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// ✅ imports des modèles liés ou utilisés dans les relations
use App\Models\Don;
use App\Models\Role;
use App\Models\Cagnotte;
use App\Models\OrganisationDocument;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function dons(): HasMany
    {
        return $this->hasMany(Don::class, 'donateur_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function cagnottes(): HasMany
    {
        return $this->hasMany(Cagnotte::class, 'organisateur_id');
    }

    public function organisationDocuments(): HasMany
    {
        return $this->hasMany(OrganisationDocument::class);
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
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isDonateur(): bool
    {
        return $this->role?->name === 'donateur';
    }

    public function isOrganisateur(): bool
    {
        return $this->role?->name === 'organisateur';
    }
}
