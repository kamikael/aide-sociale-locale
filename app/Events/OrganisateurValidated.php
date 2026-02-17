<?php

namespace App\Events;

use App\Models\Utilisateur;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrganisateurValidated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Utilisateur $utilisateur
    ) {}
}
