<?php

namespace App\Http\Controllers;

use App\Models\Cagnotte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CagnotteController extends Controller
{
    public function create()
    {
        return view('cagnottes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'video_url' => ['nullable', 'url'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cagnottes', 'public');
        }

        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;

        while (Cagnotte::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        Cagnotte::create([
            'organisateur_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image_path' => $imagePath,
            'video_url' => $request->video_url,
            'target_amount' => $request->target_amount,
            'collected_amount' => 0,
            'status' => 'active',
            'published_at' => now(),
        ]);

        return redirect()
            ->route('organisateur.cagnottes')
            ->with('success', 'Cagnotte créée avec succès.');
    }

    public function edit(Cagnotte $cagnotte)
    {
        abort_unless($cagnotte->organisateur_id === Auth::id(), 403);

        return view('cagnottes.edit', compact('cagnotte'));
    }

    public function update(Request $request, Cagnotte $cagnotte)
    {
        abort_unless($cagnotte->organisateur_id === Auth::id(), 403);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'video_url' => ['nullable', 'url'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'video_url' => $request->video_url,
        ];

        if ($request->hasFile('image')) {
            if ($cagnotte->image_path && Storage::disk('public')->exists($cagnotte->image_path)) {
                Storage::disk('public')->delete($cagnotte->image_path);
            }

            $data['image_path'] = $request->file('image')->store('cagnottes', 'public');
        }

        $cagnotte->update($data);

        return redirect()
            ->route('organisateur.cagnottes')
            ->with('success', 'Cagnotte mise à jour avec succès.');
    }

    public function destroy(Cagnotte $cagnotte)
    {
        abort_unless($cagnotte->organisateur_id === Auth::id(), 403);

        if ($cagnotte->image_path && Storage::disk('public')->exists($cagnotte->image_path)) {
            Storage::disk('public')->delete($cagnotte->image_path);
        }

        $cagnotte->delete();

        return redirect()
            ->route('organisateur.cagnottes')
            ->with('success', 'Cagnotte supprimée avec succès.');
    }


   public function show(string $slug)
{
    $cagnotte = Cagnotte::where('slug', $slug)
        ->where('status', 'active')
        ->with('organisateur')
        ->firstOrFail();

    $montantCollecte = $cagnotte->collected_amount ?? 0;
    $objectif = $cagnotte->target_amount ?? 0;

    $progression = $objectif > 0
        ? round(($montantCollecte / $objectif) * 100)
        : 0;

    return view('cagnottes.show', compact(
        'cagnotte',
        'montantCollecte',
        'objectif',
        'progression'
    ));
}
}