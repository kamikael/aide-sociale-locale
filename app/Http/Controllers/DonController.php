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
            'phone_number' => 'required|string|min:8',
            'montant' => 'required|numeric|min:100', // Minimum 1000 FCFA
             'provider_id' => 'required|exists:mobile_money_providers,id',
        ]);
        
        if ($cagnotte->user_id === Auth::id()) {
    abort(403, 'Vous ne pouvez pas faire un don à votre propre cagnotte.');
}


        $paiement = Paiement::create([
            'provider_id' => $request->provider_id,
            'user_id' => Auth::id(),
            'cagnotte_id' => $cagnotte->id,
            'transaction_reference' => Str::uuid(),
            'montant' => $request->montant,
            'commission_amount' => 0,
            'status' => 'pending',
             'phone_number' => $request->phone_number, // 🔥 IMPORTANT
        ]);

        $checkoutUrl = $paiementService->createCheckout(
            $paiement,
            Auth::user()->email
        );

        return redirect($checkoutUrl);
    }



 public function create(Cagnotte $cagnotte)
{
    if ($cagnotte->user_id === auth()->id()) {
        abort(403, 'Vous ne pouvez pas faire un don à votre propre cagnotte.');
    }

    $providers = MobileMoneyProvider::all();

    return view('donateur.dons.create', compact('cagnotte', 'providers'));
}
}
