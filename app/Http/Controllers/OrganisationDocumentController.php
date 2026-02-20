<?php

namespace App\Http\Controllers;

use App\Models\OrganisationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $path = $request->file('document')
            ->store('documents', 'public');

        OrganisationDocument::create([
            'user_id' => Auth::id(),
            'file_path' => $path,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Document envoyé pour validation.');
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

        return back()->with('success', 'Document approuvé.');
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

        return back()->with('success', 'Document rejeté.');
    }
}
