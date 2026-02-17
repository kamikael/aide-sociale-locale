<?php

namespace App\Services;

use App\Models\MobileMoneyProvider;
use App\Models\Paiement;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaiementService
{
    /**
     * Appel API mobile money pour initier un paiement.
     * Vérifie la réponse et retourne le statut.
     */
    public function initierPaiement(Paiement $paiement, string $numero_telephone, array $options = []): array
    {
        $provider = $paiement->mobileMoneyProvider ?? MobileMoneyProvider::where('code', $paiement->provider)->first();
        if (! $provider) {
            return ['success' => false, 'status' => 'echoue', 'message' => 'Provider non trouvé.'];
        }

        $config = config('mobilemoney.providers.' . $provider->code, config('mobilemoney.default'));
        $baseUrl = $provider->sandbox ? ($config['sandbox_url'] ?? $config['api_url']) : ($config['api_url'] ?? $provider->api_url);

        $payload = array_merge([
            'amount' => (float) $paiement->montant,
            'phone' => $numero_telephone,
            'reference' => $paiement->reference_provider ?? 'PAY-' . $paiement->id,
            'description' => $options['description'] ?? 'Don NEAL',
        ], $options);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . ($provider->api_key ?? $config['api_key'] ?? ''),
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($baseUrl . '/initiate', $payload);

            $body = $response->json();
            $success = $response->successful() && ($body['success'] ?? $body['status'] ?? false);

            if ($success) {
                $paiement->update([
                    'statut' => Paiement::STATUT_EN_ATTENTE,
                    'reference_provider' => $body['transaction_id'] ?? $body['reference'] ?? $paiement->reference_provider,
                ]);
                return [
                    'success' => true,
                    'status' => Paiement::STATUT_EN_ATTENTE,
                    'reference_provider' => $paiement->reference_provider,
                    'message' => $body['message'] ?? 'Paiement initié.',
                ];
            }

            Log::warning('PaiementService: réponse provider échouée', ['response' => $body, 'paiement_id' => $paiement->id]);
            $paiement->update(['statut' => Paiement::STATUT_ECHOUE]);
            return [
                'success' => false,
                'status' => 'echoue',
                'message' => $body['message'] ?? $body['error'] ?? 'Échec de l\'appel API.',
            ];
        } catch (\Throwable $e) {
            Log::error('PaiementService: exception', ['message' => $e->getMessage(), 'paiement_id' => $paiement->id]);
            $paiement->update(['statut' => Paiement::STATUT_ECHOUE]);
            return [
                'success' => false,
                'status' => 'echoue',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Vérifier le statut d’un paiement auprès du provider.
     */
    public function verifierStatut(Paiement $paiement): array
    {
        $provider = $paiement->mobileMoneyProvider ?? MobileMoneyProvider::where('code', $paiement->provider)->first();
        if (! $provider || ! $paiement->reference_provider) {
            return ['success' => false, 'status' => $paiement->statut];
        }

        $config = config('mobilemoney.providers.' . $provider->code, config('mobilemoney.default'));
        $baseUrl = $provider->sandbox ? ($config['sandbox_url'] ?? $config['api_url']) : ($config['api_url'] ?? $provider->api_url);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . ($provider->api_key ?? $config['api_key'] ?? ''),
            ])->get($baseUrl . '/status/' . $paiement->reference_provider);

            $body = $response->json();
            $status = $body['status'] ?? $body['state'] ?? null;

            $statutMap = ['completed' => Paiement::STATUT_REUSSI, 'success' => Paiement::STATUT_REUSSI, 'failed' => Paiement::STATUT_ECHOUE];
            $newStatut = $statutMap[$status] ?? $paiement->statut;

            return [
                'success' => $response->successful(),
                'status' => $newStatut,
                'raw' => $body,
            ];
        } catch (\Throwable $e) {
            Log::error('PaiementService: verifierStatut exception', ['message' => $e->getMessage()]);
            return ['success' => false, 'status' => $paiement->statut];
        }
    }
}
