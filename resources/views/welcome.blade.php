@extends('layouts.app')

@section('content')

    <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-8">
            <div class="mb-4">
                <img draggable="false" width="150" src="{{ asset("logo-protection-civile.png") }}" />
                <h1 class="display-3 fw-bold text-secondary">StockManager</h1>
                <p class="lead text-muted">Solution intelligente de gestion d'inventaire et de suivi de maintenance.</p>
            </div>

            <div class="row g-3 mb-5 text-start">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <h6 class="fw-bold text-secondary">Mouvements</h6>
                        <small class="text-muted">Suivez les entrées et sorties en temps réel.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <h6 class="fw-bold text-secondary">Maintenance</h6>
                        <small class="text-muted">Alertes automatiques pour le suivi préventif.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <h6 class="fw-bold text-secondary">Statistiques</h6>
                        <small class="text-muted">Visualisez l'état global de votre parc matériel.</small>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection