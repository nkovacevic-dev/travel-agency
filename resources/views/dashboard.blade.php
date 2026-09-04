@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Statistika kartice -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Rezervacije (ovaj mesec)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rezervacije_mesec }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ukupan prihod (mesec)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($prihod_mesec, 2) }} €</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-euro fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Aktivna putovanja
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $aktivna_putovanja }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-plane fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Ukupno putnika
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ukupno_putnika }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafikoni -->
    <div class="row">
        <!-- Rezervacije po mesecima -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Rezervacije po mesecima</h6>
                </div>
                <div class="card-body">
                    <canvas id="rezervacijeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status rezervacija -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Status rezervacija</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top destinacije -->
    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Top 5 destinacija</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Destinacija</th>
                                    <th>Broj rezervacija</th>
                                    <th>Prihod</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_destinacije as $dest)
                                <tr>
                                    <td><strong>{{ $dest->naziv }}</strong></td>
                                    <td><span class="badge bg-primary">{{ $dest->broj_rezervacija }}</span></td>
                                    <td>{{ number_format($dest->ukupan_prihod, 2) }} €</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nedavne rezervacije -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Nedavne rezervacije</h6>
                    <a href="{{ route('rezervacije.index') }}" class="btn btn-sm button-primary">Sve rezervacije</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Ime</th>
                                    <th>Putovanje</th>
                                    <th>Datum</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nedavne_rezervacije as $rez)
                                <tr>
                                    <td>{{ $rez->puno_ime }}</td>
                                    <td>{{ $rez->putovanje->naziv ?? 'N/A' }}</td>
                                    <td>{{ $rez->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $rez->status->boja() }}">
                                            {{ $rez->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Rezervacije po mesecima - Line Chart
const ctxRezervacije = document.getElementById('rezervacijeChart');
new Chart(ctxRezervacije, {
    type: 'line',
    data: {
        labels: {!! json_encode($rezervacije_po_mesecima->pluck('mesec')) !!},
        datasets: [{
            label: 'Broj rezervacija',
            data: {!! json_encode($rezervacije_po_mesecima->pluck('broj')) !!},
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Status rezervacija - Doughnut Chart
const ctxStatus = document.getElementById('statusChart');
new Chart(ctxStatus, {
    type: 'doughnut',
    data: {
        labels: ['Nove', 'Potvrđene', 'Otkazane'],
        datasets: [{
            data: [{{ $status_stats['nova'] ?? 0 }}, {{ $status_stats['potvrđena'] ?? 0 }}, {{ $status_stats['otkazana'] ?? 0 }}],
            backgroundColor: [
                'rgb(255, 193, 7)',
                'rgb(40, 167, 69)',
                'rgb(220, 53, 69)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>
@endsection
