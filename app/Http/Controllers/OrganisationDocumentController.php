<?php

namespace App\Http\Controllers;

use App\Models\OrganisationDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganisationDocumentController extends Controller
{
    /**
     * Upload et enregistrement d’un document (fichier) avec statut pending.
     */
    public function upload(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:utilisateurs,id_utilisateur',
            'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('fichier');
        $path = $file->store('organisation_documents/' . $validated['user_id'], 'public');

        $doc = OrganisationDocument::create([
            'user_id' => $validated['user_id'],
            'fichier_path' => $path,
            'nom_fichier' => $file->getClientOriginalName(),
            'statut' => OrganisationDocument::STATUT_PENDING,
        ]);

        return response()->json([
            'message' => 'Document enregistré. En attente de validation admin.',
            'document' => $doc,
        ], 201);
    }

    /**
     * Store fichier (alias / variante pour enregistrer un document).
     */
    public function store(Request $request): JsonResponse
    {
        return $this->upload($request);
    }
}
