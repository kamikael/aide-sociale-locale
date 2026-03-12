<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si pas connecté
        if (!$user) {
            return redirect()->route('login');
        }

        // Si email non vérifié
        if (is_null($user->email_verified_at)) {

            // Si requête JSON (API)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Votre adresse email doit être vérifiée.'
                ], 403);
            }

            return redirect()
                ->route('verification.notice')
                ->with('warning', 'Veuillez vérifier votre adresse email pour continuer.');
        }

        return $next($request);
    }
}