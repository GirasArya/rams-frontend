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
                <form id="AssetRecordForm" action="{{ route('admin.asset.store') }}" method="POST"
                    class="d-flex flex-column " style="gap:1rem;">
                    @csrf
                    <div>
                        <h5>Ruas Jalan Tol</h5>
                        <select name="ruas_jalan" class="form-control" id="ruas_jalan">
                            <option value="" selected disabled>Pilih satu</option>
                        </select>
                    </div>

                    <div>
                        <h5>Jenis Aset</h5>
                        <input name="jenis_aset" id="jenis_aset" required type="text" class="form-control"
                            placeholder="Pilih satu" aria-describedby="basic-addon1">
                    </div>

                    <div class="w-100">
                        <h5>Titik KM</h5>
                        <select name="titik_km" id="titik_km" class="form-control">
                            <option value=""></option>
                        </select>
                        {{-- <input required type="text" class="form-control" placeholder="Pilih satu"
                    aria-describedby="basic-addon1"> --}}
                    </div>

                    {{-- <div class="d-flex justify-content-between" style="gap:1rem;">
                    <div class="w-100">
                        <h5>Titik KM Akhir</h5>
                        <input required type="text" class="form-control" placeholder="Pilih satu"
                            aria-describedby="basic-addon1">
                    </div>
                </div> --}}

                    <div class="d-flex justify-content-between" style="gap:1rem;">
                        <div class="w-100">
                            <h5>Status Kondisi</h5>
                            <input name="status" id="status" required type="text" class="form-control"
                                placeholder="Pilih satu" aria-describedby="basic-addon1">
                        </div>

                        <div class="w-100">
                            <h5>Masa hidup</h5>
                            <input name="masa_hidup" id="masa_hidup" required type="text" class="form-control"
                                placeholder="Dalam Tahun (Contoh : 1 Tahun)" aria-describedby="basic-addon1">
                        </div>
                    </div>

                    {{-- <div>
                        <h5>GeoJSON</h5>
                        <input type="text" class="form-control" placeholder="Pilih satu" aria-describedby="basic-addon1">
                    </div> --}}

                    <div>
                        <h5>Tanggal Pemasangan</h5>
                        <input name="tanggal_pemasangan" id="tanggal_pemasangan" required type="date"
                            class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 10%; align-self:flex-end;">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </section>


    <script>
        document.getElementById('ruas_jalan').addEventListener('change', async function() {
            const nilaiIriDropdown = document.getElementById('ruas_jalan').value
            console.log(nilaiIriDropdown)

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const ruasJalanSelect = $("#ruas_jalan").select({
                allowClear: true,
                width: "100%",
            });

            try {
                const response = await fetch("http://localhost:8080/api/get-ruas-jalan");
                const data = await response.json();
                const options = data.data;
                const ruasJalan = document.createDocumentFragment();
                options.forEach((option) => {
                    const optionVal = option.id
                    const displayText = option.nama;
                    const newOption = new Option(displayText, optionVal, false, false);
                    ruasJalan.appendChild(newOption);
                });
                ruasJalanSelect.append(ruasJalan).trigger("change");
            } catch (error) {
                console.error("Error fetching bagian_jalan options:", error);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const startKmSelect = $("#titik_km").empty().select({
                allowClear: true,
                width: "100%",
            });

            try {
                const response = await fetch(
                    `http://localhost:8080/api/get-km-iri-options/${null}`);
                const data = await response.json();
                const options = data.data;
                const titiKKm = document.createDocumentFragment();

                if (options.length === 0) {
                    const noDataOption = new Option("No data", "", false, false);
                    titiKKm.appendChild(noDataOption);
                } else {
                    options.forEach((option) => {
                        const displayText = option.km;
                        const newOption = new Option(displayText, option.km, false, false);
                        titiKKm.appendChild(newOption);
                    });
                }
                startKmSelect.append(titiKKm).trigger("change");
            } catch (error) {
                console.error("Error fetching bagian_jalan options:", error);
            }
        });
    </script>
@endsection
