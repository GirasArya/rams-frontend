@extends('layouts/app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $dashboard['total_ruas'] }}</h3>
                    <p class="font-weight-bold">Total Ruas Jalan Tol</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $dashboard['jumlah_user'] }}</h3>
                    <p class="font-weight-bold">Jumlah User</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $dashboard['jumlah_ruas_user'] }}</h3>
                    <p class="font-weight-bold">Ruas Jalan Tol Anda</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $dashboard['jumlah_leger_user'] }}</h3>
                    <p class="font-weight-bold">Data Leger Anda</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lintas Harian Rata-Rata (LHR)</h3>
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="LHR" style="width: 50%; margin: auto;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">International Roughness Index (IRI)</h3>
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="IRI" style="width: 50%; margin: auto;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Aset Terbaru</h3>
                        <a href="" class="text-bold">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="d-flex justify-content-center">Belum ada data</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Rencana Pemeliharaan</h3>
                        <a href="{{ route('admin.maintenance') }}" class="text-bold">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="d-flex justify-content-center">Belum ada data</p>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Leger</h3>
            </div>
            <div class="card-body">
                Tabel Data Leger.
            </div>
        </div> -->
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('LHR');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Golongan I', 'Golongan II', 'Golongan III', 'Golongan IV', 'Golongan V'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $dashboard['lhr_gol_i'] }}, {{ $dashboard['lhr_gol_ii'] }}, {{ $dashboard['lhr_gol_iii'] }}, {{ $dashboard['lhr_gol_iv'] }}, {{ $dashboard['lhr_gol_v'] }}],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 205, 86)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 99, 132)',
                ]
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>
<script>
    const ctx2 = document.getElementById('IRI');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['< 4 (Baik)', '4-8 (Sedang)', '8-12 (Rusak Ringan)', '> 12 (Rusak Berat)'],
            datasets: [{
                label: 'Nilai IRI',
                data: [{{ $dashboard['iri_baik'] }}, {{ $dashboard['iri_sedang'] }}, {{ $dashboard['iri_rusak_ringan'] }}, {{ $dashboard['iri_rusak_berat'] }},],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 99, 132)',
                ]
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>
@endsection