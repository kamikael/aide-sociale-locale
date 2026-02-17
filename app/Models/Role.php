<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id_role';

    public $incrementing = true;

    protected $fillable = [
        'libelle_role',
    ];

    public function utilisateurs(): BelongsToMany
    {
        return $this->belongsToMany(Utilisateur::class, 'utilisateur_role', 'id_role', 'id_utilisateur');
    }
}
