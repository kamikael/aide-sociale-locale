<?php

namespace App\Http\Controllers;

use App\Models\OrganisationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganisationDocumentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Upload Document
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $path = $request->file('document')->store('documents', 'public');

        OrganisationDocument::create([
            'user_id' => Auth::id(),
            'file_path' => $path,
            'status' => 'pending',
            'validated_by' => null,
            'validated_at' => null,
        ]);

        return back()->with('success', 'Document envoyé pour validation.');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Consulter
    |--------------------------------------------------------------------------
    */
    public function show(OrganisationDocument $document)
    {
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($document->file_path)) {
            abort(404, 'Document introuvable.');
        }

        return response()->file($disk->path($document->file_path));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Approuver
    |--------------------------------------------------------------------------
    */
    public function approve(OrganisationDocument $document)
    {
        $document->update([
            'status' => 'approved',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        $document->user->update([
            'status' => 'active',
        ]);

        return back()->with('success', 'Document approuvé et organisateur validé.');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Rejeter
    |--------------------------------------------------------------------------
    */
    public function reject(OrganisationDocument $document)
    {
        $document->update([
            'status' => 'rejected',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        $document->user->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Document rejeté et organisateur rejeté.');
    }
}