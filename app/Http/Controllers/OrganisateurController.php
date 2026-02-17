public function dashboard()
{
    $user = auth()->user();

    $totalCagnottes = $user->cagnottes()->count();
    $totalCollected = $user->cagnottes()->sum('collected_amount');
    $activeCagnottes = $user->cagnottes()->where('status', 'active')->count();
    $closedCagnottes = $user->cagnottes()->where('status', 'closed')->count();

    return view('organisateur.dashboard', compact(
        'totalCagnottes',
        'totalCollected',
        'activeCagnottes',
        'closedCagnottes'
    ));
}
