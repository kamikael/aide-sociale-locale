<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganisationDocument extends Model
{
    protected $table = 'organisation_documents';

    protected $fillable = [
        'user_id',
        'fichier_path',
        'nom_fichier',
        'statut',
        'commentaire_admin',
        'valide_at',
    ];

    protected $casts = [
        'valide_at' => 'datetime',
    ];

    public const STATUT_PENDING = 'pending';
    public const STATUT_VALIDE = 'valide';
    public const STATUT_REJETE = 'rejete';

    public function user(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'user_id', 'id_utilisateur');
    }

    public function isPending(): bool
    {
        return $this->statut === self::STATUT_PENDING;
    }

    public function isValidated(): bool
    {
        return $this->statut === self::STATUT_VALIDE;
    }
}
