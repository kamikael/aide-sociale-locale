<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';

    protected $primaryKey = 'id_utilisateur';

    protected $fillable = [
        'nom',
        'email',
        'statut_validation',
    ];

    protected $casts = [
        //
    ];

    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_VALIDE = 'valide';
    public const STATUT_REJETE = 'rejete';

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'utilisateur_role', 'id_utilisateur', 'id_role');
    }

    public function dons(): HasMany
    {
        return $this->hasMany(Don::class, 'utilisateur_id');
    }

    public function isOrganisateurValide(): bool
    {
        return $this->statut_validation === self::STATUT_VALIDE;
    }

    public function scopeEnAttenteValidation($query)
    {
        return $query->where('statut_validation', self::STATUT_EN_ATTENTE);
    }
}
