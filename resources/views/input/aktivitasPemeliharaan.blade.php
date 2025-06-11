@extends('layouts/app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Tambah Rencana Pemeliharaan</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.maintenance') }}">Maintenance</a></li>
                        <li class="breadcrumb-item active">Tambah Rencana</li>
                    </ol>
                </div>
            </div>
    </section>

    <section class="content">
        <div class="card mb-4">
            <div class="card-body">
                <form id="maintenanceForm" action="{{ route('admin.maintenance.store') }}" method="POST"
                    class="p-2 d-flex flex-column gap-3">
                    @csrf
                    <div>
                        <h6>Nama Rencana</h6>
                        <input class="form-control" type="text" name="namaRencana" id="namaRencana">
                    </div>
                    <div>
                        <h6>Ruas Jalan tol</h6>
                        <select name="ruas_jalan" class="form-control" id="ruas_jalan">
                            <option value="" selected disabled>Pilih satu</option>
                            @foreach ($ruas_jalan as $ruas)
                                <option value="{{ $ruas['id'] }}">{{ $ruas['nama'] }} ({{ $ruas['tahun'] }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="w-100">
                            <h6>Index IRI</h6>
                            <select class="form-control" name="indexIRI" id="indexIRI">
                                <option value="" disabled selected>Pilih Satu</option>
                                <option value="Baik">Baik (< 4)</option>
                                <option value="Sedang">Sedang (4 - 8)</option>
                                <option value="Rusak Ringan">Rusak Ringan (8 - 12)</option>
                                <option value="Rusak Berat">Rusak Berat (> 12)</option>
                            </select>
                        </div>
                        <div class="w-100">
                            <h6>Jalur</h6>
                            <select class="form-control" name="jalur" id="jalur">
                                <option value="" disabled selected>Pilih Satu</option>
                                <option value="Kiri">Kiri</option>
                                <option value="Kanan">Kanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="w-100">
                            <h6>Titik KM Awal</h6>
                            <select class="form-control" name="kmAwal" id="kmAwal">
                                <option value="" disabled selected>Pilih Satu</option>
                            </select>
                        </div>
                        <div class="w-100">
                            <h6>Titik KM Akhir</h6>
                            <select class="form-control" name="kmAkhir" id="kmAkhir">
                                <option value="" disabled selected>Pilih Satu</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="w-100">
                            <h6>Periode Awal</h6>
                            <input class="form-control" type="date" name="periodeAwal" id="periodeAwal">
                        </div>
                        <div class="w-100">
                            <h6>Periode Akhir</h6>
                            <input class="form-control" type="date" name="periodeAkhir" id="periodeAkhir">
                        </div>
                    </div>
                    <input type="hidden" name="detail_aktivitas" id="detail_aktivitas">
                </form>

                <div class="pt-4 d-flex flex-column gap-2">
                    <div class="d-flex align-items-center justify-content-between ">
                        <h5>Aktivitas Kegiatan</h5>

                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#RencanaPemeliharaanModal1">
                            Tambah +
                        </button>
                    </div>
                    <div id="textDataKosong" class="d-flex align-items-center justify-content-center" style="height: 10rem">
                        <h4>Belum Ada Aktivitas</h4>
                    </div>

                    <div id="aktivitasTableContainer"></div>

                    <div class="d-flex align-items-center justify-content-end">
                        <button id="submitMaintenance" type="button" class="btn btn-success">Submit Rencana</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal 1-->
    <form id="maintenanceModal">
        {{-- @csrf --}}
        <div class="modal fade" id="RencanaPemeliharaanModal1" tabindex="-1" aria-labelledby="RencanaPemeliharaan"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="RencanaPemeliharaan">Tambah Aktivitas Pemeliharaan</h3>
                    </div>
                    <div class="modal-body">
                        <section class="d-flex flex-column" style="gap:1rem;">
                            <div>
                                <h6>Jenis Pemeliharaan</h6>
                                <select name="jenis_pemeliharaan" class="form-control" id="jenis_pemeliharaan">
                                    <option value="" selected disabled>Pilih satu</option>
                                    <option value="rutin">Pemeliharaan Rutin</option>
                                    <option value="berkala">Pemeliharaan Berkala</option>
                                </select>
                            </div>
                            <div>
                                <h6>Nama Kegiatan</h6>
                                <input required type="text" class="form-control" name="namaKegiatan"
                                    aria-describedby="basic-addon1">
                            </div>
                            <div class="d-flex gap-2">
                                <div class="w-100">
                                    <h6>Frekuensi Minimum Kegiatan</h6>
                                    <input class="form-control" type="text" name="frekuensi" id="frekuensi">
                                </div>
                                <div class="w-100">
                                    <h6>Jumlah Tenaga Kerja</h6>
                                    <input class="form-control" type="text" name="tenagaKerja" id="tenagaKerja">
                                </div>
                            </div>
                            <div>
                                <h6>Anggaran Kegiatan per Meter</h6>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp.</span>
                                    <input required type="text" class="form-control" name="anggaranKegiatanPerMeter"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('indexIRI').addEventListener('change', async function() {
            const nilaiIriDropdown = document.getElementById('indexIRI').value
            try {
                const response = await fetch(
                    `http://localhost:8080/api/get-km-iri-options/${nilaiIriDropdown}`);
                const data = await response.json();
                const options = data.data;
                const startKmFragment = document.createDocumentFragment();
                const endKmFragment = document.createDocumentFragment();

                if (options.length === 0) {
                    const noDataOption = new Option("No data", "", false, false);
                    startKmFragment.appendChild(noDataOption);
                    endKmFragment.appendChild(noDataOption.cloneNode(true));
                } else {
                    options.forEach((option) => {
                        const displayText = option.km;
                        const newOption = new Option(displayText, option.km, false, false);
                        startKmFragment.appendChild(newOption);
                        endKmFragment.appendChild(newOption.cloneNode(true));
                    });
                }

                const startKmSelect = $("#kmAwal").empty().select({
                    allowClear: true,
                    width: "100%",
                });
                const endKmSelect = $("#kmAkhir").empty().select({
                    allowClear: true,
                    width: "100%",
                });

                startKmSelect.append(startKmFragment).trigger("change");
                endKmSelect.append(endKmFragment).trigger("change");
            } catch (error) {
                console.error("Error fetching bagian_jalan options:", error);
            }
        });
    </script>

    <script>
        let aktivitasList = [];

        function renderAktivitasTable() {
            const container = document.getElementById('aktivitasTableContainer');
            const emptyMessage = document.getElementById('textDataKosong');
            if (aktivitasList.length === 0) {
                container.innerHTML = '';
                emptyMessage.classList.remove('d-none'); // tampilkan pesan kalau kosong
                return;
            }

            emptyMessage.classList.add('d-none'); // sembunyikan pesan kalau ada data


            let table = `
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Pemeliharaan</th>
                            <th>Nama Kegiatan</th>
                            <th>Frekuensi</th>
                            <th>Tenaga Kerja</th>
                            <th>Anggaran per Meter</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            aktivitasList.forEach(item => {
                table += `
                    <tr>
                        <td>${item.jenis_pemeliharaan}</td>
                        <td>${item.namaKegiatan}</td>
                        <td>${item.frekuensi}</td>
                        <td>${item.tenagaKerja}</td>
                        <td>Rp ${item.anggaranKegiatanPerMeter}</td>
                    </tr>
                `;
            });

            table += '</tbody></table>';
            container.innerHTML = table;
        }

        document.getElementById('maintenanceModal').addEventListener('submit', function(e) {
            e.preventDefault(); // cegah submit form biasa

            const jenis_pemeliharaan = document.getElementById('jenis_pemeliharaan').value;
            const namaKegiatan = document.querySelector('[name="namaKegiatan"]').value;
            const frekuensi = document.getElementById('frekuensi').value;
            const tenagaKerja = document.getElementById('tenagaKerja').value;
            const anggaranKegiatanPerMeter = document.querySelector('[name="anggaranKegiatanPerMeter"]').value;

            if (!jenis_pemeliharaan || !namaKegiatan || !frekuensi || !tenagaKerja || !anggaranKegiatanPerMeter) {
                alert('Semua field harus diisi!');
                return;
            }

            aktivitasList.push({
                jenis_pemeliharaan,
                namaKegiatan,
                frekuensi,
                tenagaKerja,
                anggaranKegiatanPerMeter
            });
            console.log(aktivitasList)
            renderAktivitasTable();

            // Tutup modal
            const modalEl = document.getElementById('RencanaPemeliharaanModal1');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();

            // Reset form setelah tambah
            this.reset();
        });
    </script>

    <script>
        document.getElementById('submitMaintenance').addEventListener('click', function() {
            document.getElementById('detail_aktivitas').value = JSON.stringify(aktivitasList);
            document.getElementById('maintenanceForm').submit();
        });
    </script>
@endsection
