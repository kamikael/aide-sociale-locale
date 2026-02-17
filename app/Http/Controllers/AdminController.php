<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cagnotte;
use App\Models\Paiement;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ========================================================
    // 1️⃣ Dashboard Admin
    // Affiche les chiffres globaux : total cagnottes, collecté, actives, fermées
    // ========================================================
    public function dashboard()
    {
        $totalCagnottes = Cagnotte::count();
        $totalCollected = Cagnotte::sum('collected_amount');
        $activeCagnottes = Cagnotte::where('status', 'active')->count();
        $closedCagnottes = Cagnotte::where('status', 'closed')->count();

        return view('admin.dashboard', [
            'totalCagnottes' => $totalCagnottes,
            'totalCollected' => $totalCollected,
            'activeCagnottes' => $activeCagnottes,
            'closedCagnottes' => $closedCagnottes
        ]);
    }

    // ========================================================
    // 2️⃣ Statistiques Paiements
    // Prépare les données pour les graphiques (Chart.js)
    // ========================================================
    public function statistiques()
    {
        $data = Paiement::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(montant) as total')
                )
                ->where('status', 'success')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

        $months = [];
        $totals = [];

        foreach ($data as $item) {
            $months[] = $item->month;
            $totals[] = $item->total;
        }

        return view('admin.statistiques', compact('months', 'totals'));
    }

    // ========================================================
    // 3️⃣ Validation Organisateurs
    // Liste les organisateurs en attente de validation
    // ========================================================
    public function validationOrganisateurs()
    {
        $organisateurs = User::where('role_id', Role::where('name','organisateur')->first()->id)
                              ->where('status','pending')
                              ->get();

        return view('admin.validation_organisateurs', compact('organisateurs'));
    }

    // ========================================================
    // 4️⃣ Approuver un Organisateur
    // Change le status de pending -> active
    // ========================================================
    public function approveOrganisateur($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success','Organisateur approuvé');
    }

    // ========================================================
    // 5️⃣ Rejeter un Organisateur
    // Change le status de pending -> rejected
    // ========================================================
    public function rejectOrganisateur($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        return redirect()->back()->with('error','Organisateur rejeté');
    }

    // ========================================================
    // 6️⃣ Liste des Paiements
    // Affiche tous les paiements Mobile Money
    // ========================================================
    public function paiements()
    {
        $paiements = Paiement::with('provider')->orderBy('created_at','desc')->get();
        return view('admin.paiements', compact('paiements'));
    }

} // fin de la classe AdminController
