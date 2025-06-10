@extends('layouts.app')

@section('content')
<div class="container fixed-box mt-4" id="dashboard-container">
    <div id="dashboard-selector">
        <h2 class="text-center mb-4">Dashboard de Ventas</h2>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm" onclick="showDashboard('ventasMes')">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-2x mb-2 text-danger"></i>
                        <h5 class="card-title">Ventas por Mes</h5>
                        <canvas id="miniChartMes" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm" onclick="showDashboard('ventasAño')">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar fa-2x mb-2 text-danger"></i>
                        <h5 class="card-title">Ventas por Año</h5>
                        <canvas id="miniChartAño" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm" onclick="showDashboard('topProductos')">
                    <div class="card-body text-center">
                        <i class="fas fa-box-open fa-2x mb-2 text-danger"></i>
                        <h5 class="card-title">Top 5 Productos</h5>
                        <canvas id="miniChartProd" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm" onclick="showDashboard('distribucionAnual')">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-pie fa-2x mb-2 text-danger"></i>
                        <h5 class="card-title">Distribución Anual</h5>
                        <canvas id="miniChartDona" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="dashboard-detalle" style="display: none;">
        <button class="btn btn-secondary mb-3" onclick="volverSelector()">← Volver</button>
        <div id="contenido-dashboard"></div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Función para mostrar el dashboard seleccionado
    function showDashboard(tipo) {
        document.getElementById('dashboard-selector').style.display = 'none';
        document.getElementById('dashboard-detalle').style.display = 'block';
        
        const contenido = document.getElementById('contenido-dashboard');
        contenido.innerHTML = '<div class="text-center"><div class="spinner-border text-danger" role="status"></div></div>';
        
        // Crear el canvas para el gráfico con un contenedor que mantenga la proporción
        contenido.innerHTML = `
            <div style="height: 500px; display: flex; justify-content: center; align-items: center;">
                <div style="width: 80%; height: 80%; display: flex; justify-content: center; align-items: center;">
                    <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>
            </div>`;
        
        // Configurar el gráfico según el tipo seleccionado
        let chartConfig;
        switch(tipo) {
            case 'ventasMes':
                chartConfig = {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($mesesLabels) !!},
                        datasets: [{
                            label: 'Ventas por Mes',
                            data: {!! json_encode($ventasMesData) !!},
                            borderColor: '#a64b4b',
                            tension: 0.1,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: { y: { beginAtZero: true } }
                    }
                };
                break;
            case 'ventasAño':
                chartConfig = {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($añoLabels) !!},
                        datasets: [{
                            label: 'Ventas por Año',
                            data: {!! json_encode($ventasAñoData) !!},
                            backgroundColor: [
                                '#FFB3BA', // Rosa pastel
                                '#BAFFC9', // Verde pastel
                                '#BAE1FF', // Azul pastel
                                '#FFFFBA', // Amarillo pastel
                                '#FFB3FF'  // Morado pastel
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: { y: { beginAtZero: true } }
                    }
                };
                break;
            case 'topProductos':
                chartConfig = {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($productoLabels) !!},
                        datasets: [{
                            data: {!! json_encode($ventasProductoData) !!},
                            backgroundColor: [
                                '#FFB3BA', // Rosa pastel
                                '#BAFFC9', // Verde pastel
                                '#BAE1FF', // Azul pastel
                                '#FFFFBA', // Amarillo pastel
                                '#FFB3FF'  // Morado pastel
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { 
                            legend: { 
                                position: 'bottom',
                                labels: {
                                    boxWidth: 15,
                                    padding: 15
                                }
                            }
                        },
                        layout: {
                            padding: {
                                top: 20,
                                bottom: 20
                            }
                        }
                    }
                };
                break;
            case 'distribucionAnual':
                chartConfig = {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($mesesLabels) !!},
                        datasets: [{
                            data: {!! json_encode($ventasMesData) !!},
                            backgroundColor: [
                                '#FFB3BA', // Rosa pastel
                                '#BAFFC9', // Verde pastel
                                '#BAE1FF', // Azul pastel
                                '#FFFFBA', // Amarillo pastel
                                '#FFB3FF', // Morado pastel
                                '#B3FFBA', // Verde claro pastel
                                '#B3D9FF', // Azul claro pastel
                                '#FFE4B3', // Naranja pastel
                                '#E4B3FF', // Lila pastel
                                '#B3FFE4', // Turquesa pastel
                                '#FFD9B3', // Melocotón pastel
                                '#D9B3FF'  // Lavanda pastel
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { 
                            legend: { 
                                position: 'right',
                                labels: {
                                    boxWidth: 15,
                                    padding: 10
                                }
                            }
                        },
                        layout: {
                            padding: {
                                top: 20,
                                bottom: 20
                            }
                        }
                    }
                };
                break;
        }
        
        // Crear el gráfico
        new Chart(document.getElementById('dashboardChart').getContext('2d'), chartConfig);
    }

    // Función para volver al selector de dashboards
    function volverSelector() {
        document.getElementById('dashboard-detalle').style.display = 'none';
        document.getElementById('dashboard-selector').style.display = 'block';
    }
</script>
@endpush

@endsection
