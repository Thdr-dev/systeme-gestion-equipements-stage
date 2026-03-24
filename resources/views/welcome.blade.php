@extends('layouts.app')

@section('content')

    <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-8">
            <div class="mb-4">
                <img class="logo" draggable="false" width="150" src="{{ asset("logo-protection-civile.png") }}" />
                <h1 class="display-3 fw-bold text-secondary">StockManager</h1>
                <p class="lead text-muted">Solution intelligente de gestion d'inventaire et de suivi de maintenance.</p>
            </div>

            <div class="row g-3 mb-3 text-start">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary bg-opacity-10 rounded-circle me-3 text-secondary" style="padding: 0.5rem 0.8rem;">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <h6 class="fw-bold text-secondary mb-0">Mouvements</h6>
                        </div>
                        <small class="text-muted">Suivez les entrées et sorties en temps réel.</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-warning bg-opacity-10 rounded-circle me-3 text-warning" style="padding: 0.5rem 0.8rem;">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h6 class="fw-bold text-secondary mb-0">Maintenance</h6>
                        </div>
                        <small class="text-muted">Alertes automatiques pour le suivi préventif.</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success bg-opacity-10 rounded-circle me-3 text-success" style="padding: 0.5rem 0.8rem;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h6 class="fw-bold text-secondary mb-0">Statistiques</h6>
                        </div>
                        <small class="text-muted">Visualisez l'état global de votre parc matériel.</small>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection