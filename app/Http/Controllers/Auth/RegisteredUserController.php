<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:donateur,organisateur'],
        ]);

        $role = Role::where('name', $request->role)->firstOrFail();
       
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'status' => $role->name === 'organisateur' ? 'pending' : 'active', // toujours pending au départ pour organisateurs
            
        ]);

        $flashMessage = [
            'success' => 'Compte créé avec succès. Vérifiez votre email.',
        ];

        try {
            event(new Registered($user));
        } catch (\Throwable $e) {
            Log::error('Erreur envoi email de verification apres inscription', [
                'user_id' => $user->id,
                'email' => $user->email,
                'message' => $e->getMessage(),
            ]);

            $flashMessage['warning'] = 'Compte créé, mais l\'email de vérification n\'a pas pu être envoyé pour le moment.';
        }

        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with($flashMessage);
    }
}
