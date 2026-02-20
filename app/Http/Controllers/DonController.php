<?php

namespace App\Http\Controllers;

use App\Models\Don;
use App\Models\Paiement;
use App\Models\Cagnotte;
use App\Models\MobileMoneyProvider;
use App\Services\PaiementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DonController extends Controller
{
    public function store(Request $request, Cagnotte $cagnotte, PaiementService $paiementService)
    {
        $request->validate([
            'montant' => 'required|numeric|min:100',
        ]);

        $provider = MobileMoneyProvider::first(); // FedaPay agrégateur

        $paiement = Paiement::create([
            'provider_id' => $provider->id,
            'transaction_reference' => Str::uuid(),
            'montant' => $request->montant,
            'commission_amount' => 0,
            'status' => 'pending',
        ]);

        $don = Don::create([
            'donateur_id' => Auth::id(),
            'cagnotte_id' => $cagnotte->id,
            'paiement_id' => $paiement->id,
            'montant' => $request->montant,
        ]);

        $checkoutUrl = $paiementService->createCheckout(
            $paiement,
            Auth::user()->email
        );

        return redirect($checkoutUrl);
    }
}
