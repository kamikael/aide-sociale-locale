@extends('layouts.dashboard')

@section('title', 'Statistiques')
@section('page-title', 'Statistiques Plateforme')

@section('content')
<div class="container">
    <h2>Statistiques Paiements</h2>
    <canvas id="paiementsChart" width="400" height="150"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('paiementsChart').getContext('2d');
    const paiementsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Total Paiements (FCFA)',
                data: @json($totals),
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
