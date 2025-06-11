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
                        <h3>{{ $dashboard['assetSum'] }}</h3>
                        <p class="font-weight-bold">Total Aset Jalan Tol</p>
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

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jumlah Aset</h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="asetChart" style="width:100%; margin: auto;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aset Per Ruas</h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="asetPerRuasChart" style="width: 100%;"></canvas>
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
                            <a href="{{ route('admin.manage_aset') }}" class="text-bold">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <section id="aset-data">
                        </section>

                        <section id="asetLoading" class="d-flex align-items-center justify-content-center">
                            <div class="spinner-grow" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </section>
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
                        <section id="record-data">
                        </section>

                        <section id="recordLoading" class="d-flex align-items-center justify-content-center">
                            <div class="spinner-grow" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </section>
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
                    data: [{{ $dashboard['lhr_gol_i'] }}, {{ $dashboard['lhr_gol_ii'] }},
                        {{ $dashboard['lhr_gol_iii'] }}, {{ $dashboard['lhr_gol_iv'] }},
                        {{ $dashboard['lhr_gol_v'] }}
                    ],
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
                responsive: true,
                maintainAspectRatio: false,
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
                    data: [{{ $dashboard['iri_baik'] }}, {{ $dashboard['iri_sedang'] }},
                        {{ $dashboard['iri_rusak_ringan'] }}, {{ $dashboard['iri_rusak_berat'] }},
                    ],
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 99, 132)',
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>

    <script>
        const ctx3 = document.getElementById('asetChart');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [
                    'Manhole',
                    'Patok HM',
                    'Patok KM',
                    'Patok LJ',
                    'Patok Pemandu',
                    'Patok RMJ',
                    'Patok ROW',
                    'Rambu Lalu Lintas',
                    'Rambu Penunjuk Arah',
                    // 'Reflektor',
                    'Rumah Kabel',
                    'STA',
                    'Tiang Listrik',
                    'Tiang Telepon',
                    'VMS'
                ],
                datasets: [{
                    label: 'Jumlah Aset',
                    data: [
                        {{ $dashboard['manhole'] }},
                        {{ $dashboard['patokHM'] }},
                        {{ $dashboard['patokKM'] }},
                        {{ $dashboard['patokLJ'] }},
                        {{ $dashboard['patokPemandu'] }},
                        {{ $dashboard['patokRMJ'] }},
                        {{ $dashboard['patokROW'] }},
                        {{ $dashboard['rambuLaluLintas'] }},
                        {{ $dashboard['rambuPenunjukArah'] }},
                        {{ $dashboard['rumahKabelPoint'] }},
                        {{ $dashboard['staText'] }},
                        {{ $dashboard['tiangListrik'] }},
                        {{ $dashboard['tiangTelepon'] }},
                        {{ $dashboard['vms'] }}
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah'
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 30
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const asetPerRuas = {!! json_encode($dashboard['asetPerRuas']) !!};

        const asetPerRuasLabels = Object.keys(asetPerRuas);
        const asetPerRuasData = Object.values(asetPerRuas);

        new Chart(document.getElementById('asetPerRuasChart'), {
            type: 'bar',
            data: {
                labels: asetPerRuasLabels,
                datasets: [{
                    label: 'Total Aset per Ruas',
                    data: asetPerRuasData,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Aset'
                        }
                    }
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            try {
                const response = await fetch("http://localhost:8080/api/maintenance/recent/data");
                const data = await response.json();
                const recordData = document.getElementById('record-data');
                const loading = document.getElementById('recordLoading');
                if (data.length === 0) {
                    const noDataMessage = document.createElement('p');
                    noDataMessage.textContent = 'Belum ada data';
                    noDataMessage.classList.add('d-flex', 'justify-content-center');
                    recordData.appendChild(noDataMessage);
                    loading.classList.add('d-none');
                } else {
                    data.forEach((item, key) => {
                        loading.classList.add('d-none');
                        const recordDataItem = document.createElement('div')
                        recordDataItem.innerHTML = `
                    <section class="d-flex justify-content-between align-items-center w-100 pb-3">
                         <div class="d-flex flex-column">
                             <h4 class="mb-0">
                                 ${item.nama}
                             </h4>
                            <p class="mb-0">
                                 ${new Date(item.periode_awal).getFullYear()} - ${new Date(item.periode_akhir).getFullYear()}
                             </p>
                         </div>
                         <h4>
                             ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(item.total_biaya)}
                         </h4>
                    </section>
                    `
                        recordData.appendChild(recordDataItem)
                    });
                }
            } catch (error) {
                console.error("Error fetching jalur options:", error);
            }
        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            try {
                const response = await fetch("http://localhost:8080/api/manage/recent/aset");
                const data = await response.json();
                const asetData = document.getElementById('aset-data');
                const loading = document.getElementById('asetLoading');
                if (data.length === 0) {
                    const noDataMessage = document.createElement('p');
                    noDataMessage.textContent = 'Belum ada data';
                    noDataMessage.classList.add('d-flex', 'justify-content-center');
                    asetData.appendChild(noDataMessage);
                    loading.classList.add('d-none');
                } else {
                    data.forEach((item, key) => {
                        const asetDataItem = document.createElement('div')
                        loading.classList.add('d-none');
                        asetDataItem.innerHTML =
                            `
                            <section class="d-flex justify-content-between align-items-center w-100 pb-3">
                                <div class="d-flex flex-column">
                                    <h4 class="mb-2">
                                        ${item.jenis_aset}
                                    </h4>
                                    <p class="mb-0">
                                        Ditambahkan pada : ${item.tanggal_pemasangan}
                                    </p>
                                </div>
                            </section>
                        `
                        asetData.appendChild(asetDataItem)
                    });


                }
            } catch (error) {
                console.error("Error fetching jalur options:", error);
            }
        })
    </script>
@endsection
