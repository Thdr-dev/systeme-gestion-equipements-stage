@extends('layouts.app')

@section('content')

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-6 fw-normal text-secondary d-inline">Statistiques</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0 pb-4">
            <div class="card-body row gy-4">

                <div class="col-lg-6" style="position: relative; height: 350px;">
                    <h2 class="h2 fw-normal text-center text-muted">{{ $totalMateriels }} équipements au total</h2>
                    <canvas id="statusChart" class="mb-5"></canvas>
                </div>
                <div class="col-lg-6" style="position: relative; height: 350px;">
                    <hr class="d-lg-none">
                    <h2 class="h2 fw-normal text-center text-muted">{{ $totalUnites }} unites au total</h2>
                    <canvas id="unitesChart" class="mb-5"></canvas>
                </div>

            </div>
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
                            // Force des nombres entiers (pas de 1.5, 2.5...)
                            precision: 0, 
                            // Cette fonction gère l'espacement automatique intelligemment
                            callback: function(value) {
                                if (value >= 100) return value; // Garde tel quel si > 100
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

    </script>

@endsection