<div class="row">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Total Cagnottes</h6>
                <h4>{{ $totalCagnottes ?? 0 }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Total Collecté</h6>
                <h4>{{ number_format($totalCollected ?? 0, 0, ',', ' ') }} FCFA</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Cagnottes Actives</h6>
                <h4>{{ $activeCagnottes ?? 0 }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Cagnottes Fermées</h6>
                <h4>{{ $closedCagnottes ?? 0 }}</h4>
            </div>
        </div>
    </div>

</div>
