@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')

    <div class="mt-5">

        <div class="d-flex mb-4">
            <h1 class="display-6 fw-normal text-secondary">Statistiques <span class="fs-2 text-dark"> - {{ Auth::user()->unite->nom }}</span></h1>
        </div>
        
        <div class="row mb-4 g-2 gy-3">
            <div class="col-md-3">
                <a class="btn w-100 m-0 p-0 text-start" href="{{ route('materiels.index', ['status' => 'Disponible', 'unite_id' => Auth::user()->unite_id]) }}">
                    <div class="card bg-success text-white shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title opacity-75">Disponible</h6>
                            <h3 class="mb-0">{{ $statusDistribution->get('Disponible', 0) }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn w-100 m-0 p-0 text-start" href="{{ route('materiels.index', ['status' => 'Maintenance', 'unite_id' => Auth::user()->unite_id]) }}">
                    <div class="card bg-info text-white shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title opacity-75">En Maintenance</h6>
                            <h3 class="mb-0">{{ $enMaintenance }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn w-100 m-0 p-0 text-start" href="{{ route('materiels.index', ['status' => 'Sorti', 'unite_id' => Auth::user()->unite_id]) }}">
                    <div class="card bg-warning text-dark shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title opacity-75">Sorti</h6>
                            <h3 class="mb-0">{{ $statusDistribution->get('Sorti', 0) }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn w-100 m-0 p-0 text-start" href="{{ route('materiels.index', ['status' => 'En panne', 'unite_id' => Auth::user()->unite_id]) }}">
                    <div class="card bg-danger text-white shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title opacity-75">En Panne</h6>
                            <h3 class="mb-0">{{ $enPanne }}</h3>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="card shadow-sm pb-lg-4 pb-5 pt-3">
            <div class="card-body">

                <div class="row gy-4">
                    <div class="col-lg-6" style="position: relative; height: 350px;">
                        <h2 class="h2 fw-normal text-center text-muted">{{ $totalMateriels }} équipements au total dans la Caserne</h2>
                        <canvas id="statusChart" class="mb-4 mb-lg-5"></canvas>
                    </div>
                    <div class="col-lg-6" style="position: relative; height: 350px;">
                        <hr class="d-lg-none">
                        <h2 class="h2 fw-normal text-center text-muted">{{ $totalUnites }} unites au total ( tout les casernes )</h2>
                        <canvas id="unitesChart" class="mb-5"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <br>

        <div class="card shadow-sm pb-lg-4 pb-5 pt-3">

            <div class="card-body">

                <div class="row gy-4">
                    <div class="col-lg-6" style="position: relative; height: 350px;">
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
                                            <span class="badge rounded-pill bg-primary">IMMINENT</span>
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

    <script>

        document.addEventListener('DOMContentLoaded', function () {

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
        
        })
        
    </script>

@endsection