<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyFedaPayWebhook
{
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('X-FEDAPAY-SIGNATURE');
        $secret = config('services.fedapay.webhook_secret');

        if (!$signature) {
            return response()->json(['error' => 'Missing signature'], 403);
        }

        $computedSignature = hash_hmac(
            'sha256',
            $request->getContent(),
            $secret
        );

        if (!hash_equals($computedSignature, $signature)) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        return $next($request);
    }
}
