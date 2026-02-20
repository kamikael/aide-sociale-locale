<?php

namespace App\Http\Controllers;

use App\Models\Cagnotte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CagnotteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Public - Liste des cagnottes actives
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $cagnottes = Cagnotte::active()
            ->latest()
            ->paginate(9);

        return view('cagnotte.index', compact('cagnottes'));
    }

    /*
    |--------------------------------------------------------------------------
    | Public - Détail d'une cagnotte
    |--------------------------------------------------------------------------
    */
    public function show(Cagnotte $cagnotte)
    {
        return view('cagnotte.show', compact('cagnotte'));
    }

    /*
    |--------------------------------------------------------------------------
    | Organisateur - Formulaire création
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('cagnotte.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Organisateur - Enregistrer
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('cagnottes', 'public');
        }

        Cagnotte::create([
            'organisateur_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'image_path' => $imagePath,
            'video_url' => $request->video_url,
            'collected_amount' => 0,
            'status' => 'active',
            'published_at' => now(),
        ]);

        return redirect()
            ->route('organisateur.dashboard')
            ->with('success', 'Cagnotte créée avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | Organisateur - Modifier
    |--------------------------------------------------------------------------
    */
    public function edit(Cagnotte $cagnotte)
    {
        $this->authorize('update', $cagnotte);

        return view('cagnotte.edit', compact('cagnotte'));
    }

    /*
    |--------------------------------------------------------------------------
    | Organisateur - Update
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Cagnotte $cagnotte)
    {
        $this->authorize('update', $cagnotte);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $cagnotte->image_path = $request->file('image')
                ->store('cagnottes', 'public');
        }

        $cagnotte->update([
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'video_url' => $request->video_url,
        ]);

        return redirect()
            ->route('organisateur.dashboard')
            ->with('success', 'Cagnotte mise à jour.');
    }

    /*
    |--------------------------------------------------------------------------
    | Organisateur / Admin - Supprimer
    |--------------------------------------------------------------------------
    */
    public function destroy(Cagnotte $cagnotte)
    {
        $this->authorize('delete', $cagnotte);

        $cagnotte->delete();

        return back()->with('success', 'Cagnotte supprimée.');
    }
}
