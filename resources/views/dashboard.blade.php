@extends('layouts.app')

@section('content')

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-6 fw-normal text-secondary d-inline">Statistiques</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0 pb-lg-4 pb-5 pt-3">
            <div class="card-body row gy-4">
                <div class="col-lg-6" style="position: relative; height: 350px;">
                    <h2 class="h2 fw-normal text-center text-muted">{{ $totalMateriels }} équipements au total</h2>
                    <canvas id="statusChart" class="mb-4 mb-lg-5"></canvas>
                </div>
                <div class="col-lg-6" style="position: relative; height: 350px;">
                    <hr class="d-lg-none">
                    <h2 class="h2 fw-normal text-center text-muted">{{ $totalUnites }} unites au total</h2>
                    <canvas id="unitesChart" class="mb-5"></canvas>
                </div>

            </div>
        </div>

        <div class="card shadow-sm border-0 pb-lg-4 pb-5">
            <div class="card-body row gy-4">
                <div class="col-lg-6" style="position: relative; height: 350px;">
                    <hr class="d-lg-none">
                    <h2 class="h2 fw-normal text-center text-muted">fréquence d’usage</h2>
                    <canvas id="usageChart" class="mb-4 mb-lg-5"></canvas>
                </div>
                <div class="col-lg-6" style="position: relative; height: 350px;">
                    <hr class="d-lg-none">
                    <h2 class="h2 fw-normal text-center text-muted">Pannes fréquentes</h2>
                    <canvas id="pannesChart" class="mb-5"></canvas>
                </div>

            </div>
        </div>

    </div>

    <div class="mt-5">
        <h2 class="display-6 fw-normal text-secondary mb-4">Interventions Prioritaires</h2>
        
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-secondary bg-primary">Équipement</th>
                                <th class="text-secondary bg-primary">Échéance</th>
                                <th class="text-secondary bg-primary">État</th>
                                <th class="text-secondary bg-primary">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($maintenancesUrgent as $m)
                                @php
                                    $isPast = $m->date_maintenance->isPast() && !$m->date_maintenance->isToday();
                                    $isToday = $m->date_maintenance->isToday();
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $m->nom }}</div>
                                    </td>
                                    <td>
                                        <span class="{{ $isPast ? 'text-danger fw-bold' : ( $isToday ? 'text-warning' : 'text-dark' ) }}">
                                            {{ $m->date_maintenance->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($isPast)
                                            <span class="badge rounded-pill bg-danger">RETARD</span>
                                        @elseif($isToday)
                                            <span class="badge rounded-pill bg-warning">AUJOURD'HUI</span>
                                        @else
                                            <span class="badge rounded-pill bg-primary">PROCHE</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('materiels.show', $m) }}" class="btn btn-outline-primary btn-sm">
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Aucune maintenance urgente à prévoir.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($maintenancesUrgent->count() > 0)
                <div class="card-footer table-secondary border-0 text-center py-3">
                    <a href="{{ route('materiels.index') }}" class="text-decoration-none small fw-bold">Voir tout les Materiels</a>
                </div>
            @endif
        </div>
    </div>

@endsection


@section("scripts")

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        const statusLabels = {!! json_encode($statusDistribution->keys()) !!};
        const statusColors = {
            'En panne': '#dc3545',
            'Disponible': '#28a745',
            'Sorti': '#ffc107',
            'Maintenance': '#17a2b8'
        };

        const dynamicColors = statusLabels.map(label => statusColors[label] || '#dee2e6');

        new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: {!! json_encode($statusDistribution->values()) !!},
                    backgroundColor: dynamicColors
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: { display: true, text: 'État Global du Matériel' }
                }
            }
        });


        const ctxUnites = document.getElementById('unitesChart').getContext('2d');
        new Chart(ctxUnites, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topUnites->pluck('nom')) !!},
                datasets: [{
                    label: 'Nombre de matériels',
                    data: {!! json_encode($topUnites->pluck('materiels_count')) !!},
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0, 

                            callback: function(value) {
                                if (value >= 100) return value; 
                                return value;
                            }
                        }
                    }
                },
                plugins: { 
                    title: { display: true, text: 'Top 5 Unités les plus équipées' } 
                }
            }
        });


        const ctxPannes = document.getElementById('pannesChart').getContext('2d');
        new Chart(ctxPannes, {
            type: 'bar',
            data: {
                labels: {!! json_encode(collect($pannesFrequentes)->pluck('nom')) !!},
                datasets: [{
                    label: 'Nombre de pannes',
                    data: {!! json_encode(collect($pannesFrequentes)->pluck('total')) !!},
                    backgroundColor: '#dc3545'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0, 

                            callback: function(value) {
                                if (value >= 100) return value; 
                                return value;
                            }
                        }
                    }
                },
                plugins: {
                    title: { display: true, text: 'Top 5 Matériels en panne' }
                }
            }
        });


        const ctxUsage = document.getElementById('usageChart').getContext('2d');
        new Chart(ctxUsage, {
            type: 'bar',
            data: {
                labels: {!! json_encode(collect($frequenceUsage)->pluck('nom')) !!},
                datasets: [{
                    label: 'Fréquence d’usage',
                    data: {!! json_encode(collect($frequenceUsage)->pluck('total')) !!},
                    backgroundColor: '#28a745'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0, 

                            callback: function(value) {
                                if (value >= 100) return value; 
                                return value;
                            }
                        }
                    }
                },
                plugins: {
                    title: { display: true, text: 'Top 5 Matériels les plus utilisés' }
                }
            }
        });

    </script>

@endsection