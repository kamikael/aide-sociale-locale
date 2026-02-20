<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Gère la tentative de connexion
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('Identifiants incorrects.'),
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Vérification Email
        |--------------------------------------------------------------------------
        */
        if (! $user->hasVerifiedEmail()) {
            Auth::logout();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Veuillez vérifier votre email avant de vous connecter.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Vérification Status
        |--------------------------------------------------------------------------
        */
        if ($user->status === 'rejected') {
            Auth::logout();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Votre compte a été rejeté par l’administrateur.',
                ]);
        }

        if ($user->status === 'pending') {
            Auth::logout();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Votre compte est en attente de validation par l’administrateur.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Redirection selon rôle
        |--------------------------------------------------------------------------
        */
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isOrganisateur()) {
            return redirect()->route('organisateur.dashboard');
        }

        return redirect()->route('donateur.dashboard');
    }

    /**
     * Déconnexion
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
