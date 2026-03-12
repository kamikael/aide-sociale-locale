<?php

namespace App\Services;

use App\Models\Paiement;
use App\Models\MobileMoneyProvider;
use FedaPay\Transaction;
use Illuminate\Support\Facades\Log;

class PaiementService
{
    public function __construct()
    {
        \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
        \FedaPay\FedaPay::setEnvironment(config('services.fedapay.environment'));
    }

    public function createCheckout(Paiement $paiement, string $customerEmail): string
    {
        try {
            // 🔎 Déterminer numéro + mode (doc FedaPay : 64000001 MOOV / 66000001 MTN = succès en sandbox)
            if (config('services.fedapay.environment') === 'sandbox') {
                $phoneNumber = '64000001';
                $mode = 'momo_test';
                Log::info('FedaPay sandbox: transaction créée avec 64000001. Sur la page FedaPay, saisir exactement 64000001 ou 66000001 pour succès.');
            } else {
                $phoneNumber = $this->formatPhoneNumber($paiement->phone_number);

                $mode = MobileMoneyProvider::where('id', $paiement->provider_id)
                    ->value('code');

                if (!$mode) {
                    throw new \Exception(
                        "Mode du provider introuvable pour le paiement #{$paiement->id}"
                    );
                }
            }

            // ⚠️ IMPORTANT : URL publique requise (ngrok en local).
            // FedaPay redirigera le navigateur vers cette route après paiement.
            $callbackUrl = route('paiement.callback');

            $transaction = Transaction::create([
                "description" => "Don pour cagnotte #{$paiement->id}",
                "amount" => (int) $paiement->montant,
                "currency" => ["iso" => "XOF"],
                "callback_url" => $callbackUrl,
                "mode" => $mode,
                "customer" => [
                    "email" => $customerEmail,
                    "phone_number" => [
                        "number" => (int) $phoneNumber, // API attend un entier
                        "country" => "bj",
                    ],
                ],
                "metadata" => [
                    "paiement_id" => (string) $paiement->id,
                ],
            ]);

            $token = $transaction->generateToken();

            if (!$token || empty($token->url)) {
                throw new \Exception("Impossible de générer l'URL de paiement FedaPay.");
            }

            // En sandbox : on déclenche nous-mêmes le collect avec le numéro de test 64000001
            // pour garantir un paiement accepté (sans dépendre de la saisie sur la page FedaPay).
            if (config('services.fedapay.environment') === 'sandbox') {
                try {
                    $transaction->sendNowWithToken($mode, $token->token, [
                        'phone_number' => [
                            'number' => '64000001',
                            'country' => 'bj',
                        ],
                    ]);
                    Log::info('FedaPay sandbox: collect envoyé avec 64000001', ['paiement_id' => $paiement->id]);
                } catch (\Throwable $e) {
                    Log::warning('FedaPay sandbox sendNowWithToken', [
                        'paiement_id' => $paiement->id,
                        'message' => $e->getMessage(),
                    ]);
                    // On continue : on redirige quand même vers la page FedaPay (fallback).
                }
            }

            return $token->url;

        } catch (\Throwable $e) {
            Log::error("Erreur création checkout FedaPay", [
                'message' => $e->getMessage(),
                'paiement_id' => $paiement->id ?? null,
                'email' => $customerEmail,
            ]);

            throw $e;
        }
    }

    private function formatPhoneNumber(?string $phone): string
    {
        if (!$phone) {
            throw new \Exception("Numéro de téléphone manquant.");
        }

        // garder seulement les chiffres
        $phone = preg_replace('/\D+/', '', $phone);

        // retirer 229 si présent
        if (str_starts_with($phone, '229')) {
            $phone = substr($phone, 3);
        }

        if (strlen($phone) !== 8) {
            throw new \Exception(
                "Numéro de téléphone invalide pour le Bénin : {$phone}"
            );
        }

        return $phone;
    }
}