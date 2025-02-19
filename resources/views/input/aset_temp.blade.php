@extends('layouts/app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Aset</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Input</li>
                    <li class="breadcrumb-item active">Tambah Aset</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-body px-3">
            <form action="" class="d-flex flex-column " style="gap:1rem;">
                <div>
                    <h5>Ruas Jalan Tol</h5>
                    <input required type="text" class="form-control" placeholder="Pilih satu"
                        aria-describedby="basic-addon1">
                </div>

                <div>
                    <h5>Jenis Aset</h5>
                    <input required type="text" class="form-control" placeholder="Pilih satu"
                        aria-describedby="basic-addon1">
                </div>

                <div class="d-flex justify-content-between" style="gap:1rem;">
                    <div class="w-100">
                        <h5>Titik KM Awal</h5>
                        <input required type="text" class="form-control" placeholder="Pilih satu"
                            aria-describedby="basic-addon1">
                    </div>

                    <div class="w-100">
                        <h5>Titik KM Akhir</h5>
                        <input required type="text" class="form-control" placeholder="Pilih satu"
                            aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class="d-flex justify-content-between" style="gap:1rem;">
                    <div class="w-100">
                        <h5>Status Kondisi</h5>
                        <input required type="text" class="form-control" placeholder="Pilih satu"
                            aria-describedby="basic-addon1">
                    </div>

                    <div class="w-100">
                        <h5>Masa hidup</h5>
                        <input required type="text" class="form-control" placeholder="Pilih satu"
                            aria-describedby="basic-addon1">
                    </div>
                </div>

                <div>
                    <h5>GeoJSON</h5>
                    <input type="text" class="form-control" placeholder="Pilih satu" aria-describedby="basic-addon1">
                </div>

                <div>
                    <h5>Tanggal Pemasangan</h5>
                    <input required type="text" class="form-control" placeholder="Pilih satu"
                        aria-describedby="basic-addon1">
                </div>

                <button class="btn btn-primary" style="width: 10%; align-self:flex-end;">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</section>


@endsection