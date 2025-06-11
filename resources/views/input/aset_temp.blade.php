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
                <!-- Alert -->
                @foreach (['success', 'danger'] as $message)
                    @if (session($message))
                        <div class="alert alert-{{ $message }} alert-dismissible fade show" role="alert">
                            {{ session($message) }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                @endforeach


                <form id="AssetRecordForm" action="{{ route('admin.asset.store') }}" method="POST"
                    class="d-flex flex-column " style="gap:1rem;" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <h5>Ruas Jalan Tol</h5>
                        <select name="ruas_jalan" class="form-control" id="ruas_jalan">
                            <option value="" selected disabled>Pilih satu</option>
                        </select>
                    </div>

                    <div>
                        <h5>Jenis Aset</h5>
                        <select name="jenis_aset" class="form-control" id="jenis_aset">
                            <option value="" selected disabled>Pilih satu</option>
                            @foreach ($tipe_aset as $aset)
                                <option value="{{ $aset['type'] }}">{{ $aset['text'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <h5>Tanggal Pemasangan</h5>
                        <input type="date" class="form-control" name="tanggal_pemasangan" id="tanggal_pemasangan">
                    </div>

                    <div class="form-group mb-4">
                        <label class="d-block">File GeoJSON <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="geojson" name="geojson"
                                onchange="updateFileName()">
                            <label class="custom-file-label" for="geojson">Choose file</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 10%; align-self:flex-end;">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </section>



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
        function updateFileName() {
            var input = document.getElementById('geojson');
            var label = input.nextElementSibling;
            var fileName = input.files[0].name;
            label.innerHTML = fileName;
        }
    </script>
@endsection
