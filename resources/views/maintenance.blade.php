@extends('layouts/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rencana Pemeliharaan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Maintenance</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <section class="content">
        <div class="card mb-4">
            <div class="card-body ">
                <section class="d-flex">
                    <div id="admin-map" data-route="{{ route('admin.leger.jalanUtama.generate') }}" style="height: 600px">
                    </div>
                    <section class="w-100 d-flex flex-column gap-4" style="height: 50vh;">
                        <div class="d-flex justify-content-end align-items-baseline">
                            <!-- <button class="btn btn-success">Tambah</button> -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#RencanaPemeliharaanModal1">
                                Tambah
                            </button>
                        </div>

                        <section id="recordLoading" class="d-flex align-items-center justify-content-center h-100">
                            <div class="spinner-grow" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </section>
                        <!-- Accordion -->
                        <div class="accordion ms-4" id="recordPemeliharaan" style="height: max-content; overflow-y: scroll;">
                        </div>


                    </section>
                </section>
            </div>
        </div>
    </section>

    <!-- Modal 1-->
    <form id="MaintenanceForm" action="{{ route('admin.maintenance.api') }}" method="POST">
        @csrf
        <div class="modal fade" id="RencanaPemeliharaanModal1" tabindex="-1" aria-labelledby="RencanaPemeliharaan"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="RencanaPemeliharaan">Tambah Rencana Pemeliharaan</h3>
                    </div>
                    <div class="modal-body">
                        <section class="d-flex flex-column" style="gap:1rem;">
                            <div>
                                <h5>Nama Pemeliharaan</h5>
                                <input required type="text" class="form-control" name="nama_pemeliharaan"
                                    placeholder="Tuliskan Nama Pemeliharaan" aria-describedby="basic-addon1">
                            </div>
                            <div class="d-flex justify-content-between" style="gap:1rem;">
                                <div class="w-100">
                                    <h5>Titik KM Awal</h5>
                                    <select name="titik_km_awal" class="form-control" id="titik_km_awal">
                                        <option value="" selected disabled>Pilih satu</option>
                                    </select>
                                </div>
                                <div class="w-100">
                                    <h5>Titik KM Akhir</h5>
                                    <select name="titik_km_akhir" class="form-control" id="titik_km_akhir">
                                        <option value="" selected disabled>Pilih satu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between" style="gap:1rem;">
                                <div class="w-100">
                                    <h5>Jalur</h5>
                                    <select name="jalur" class="form-control" id="jalur">
                                        <option value="" selected disabled>Pilih satu</option>
                                    </select>
                                </div>
                                <div class="w-100">
                                    <h5>Bagian Jalan</h5>
                                    <select name="bagian_jalan" class="form-control" id="bagian_jalan">
                                        <option value="" selected disabled>Pilih satu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between" style="gap:1rem;">
                                <div class="w-100">
                                    <h5>Periode Awal</h5>
                                    <input required type="date" class="form-control" name="periode_awal"
                                        placeholder="Pilih satu" aria-describedby="basic-addon1">
                                </div>
                                <div class="w-100">
                                    <h5>Periode Akhir</h5>
                                    <input required type="date" class="form-control" name="periode_akhir"
                                        placeholder="Pilih satu" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-target="#RencanaPemeliharaanModal2"
                            data-bs-toggle="modal">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 2 -->
        <div class="modal fade" id="RencanaPemeliharaanModal2" tabindex="-1" aria-labelledby="RencanaPemeliharaan"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="RencanaPemeliharaan">Tambah Rencana Pemeliharaan</h3>
                    </div>
                    <div class="modal-body">
                        <section class="d-flex flex-column" style="gap:1rem;">
                            <div>
                                <h5>Jenis Pemeliharaan</h5>
                                <select name="jenis_pemeliharaan" class="form-control" id="jenis_pemeliharaan">
                                    <option value="" selected disabled>Pilih satu</option>
                                    <option value="rutin">Pemeliharaan Rutin</option>
                                    <option value="berkala">Pemeliharaan Berkala</option>
                                </select>
                            </div>
                            <div>
                                <h5>Alokasi Biaya Pemeliharaan</h5>
                                <input required type="text" class="form-control" name="biaya_pemeliharaan"
                                    placeholder="Pilih satu" aria-describedby="basic-addon1">
                            </div>
                            <div>
                                <h5>Alokasi Biaya Impor</h5>
                                <input required type="text" class="form-control" name="biaya_impor" placeholder="Pilih satu"
                                    aria-describedby="basic-addon1">
                            </div>
                            <div>
                                <h5>Keterangan Pemeliharaan</h5>
                                <input required type="text" class="form-control" name="keterangan_pemeliharaan"
                                    placeholder="Pilih satu" aria-describedby="basic-addon1">
                            </div>
                            <!-- <div>
                                                                                                                        <h5>Total Biaya Pemeliharaan</h5>
                                                                                                                        <input type="text" name="total_biaya_pemeliharaan" disabled class="form-control">
                                                                                                                    </div> -->
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-target="#RencanaPemeliharaanModal1"
                            data-bs-toggle="modal">Return</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <!-- Async fetch options -->
        <script>
            document.addEventListener("DOMContentLoaded", async function () {
                // Inisialisasi Select2 setelah DOM selesai dimuat
                const startKmSelect = $("#titik_km_awal").select({
                    allowClear: true,
                    width: "100%",
                });

                const endKmSelect = $("#titik_km_akhir").select({
                    allowClear: true,
                    width: "100%",
                });

                // Fetch data untuk Start KM dan End KM
                try {
                    const response = await fetch("http://localhost:8080/api/get-km-iri-options");
                    const data = await response.json();
                    const options = data.data;
                    const startKmFragment = document.createDocumentFragment();
                    const endKmFragment = document.createDocumentFragment();

                    options.forEach((option) => {
                        const displayText = option.km;
                        const newOption = new Option(displayText, option.km, false, false);
                        startKmFragment.appendChild(newOption);
                        endKmFragment.appendChild(newOption.cloneNode(true));
                    });

                    startKmSelect.append(startKmFragment).trigger("change");
                    endKmSelect.append(endKmFragment).trigger("change");
                } catch (error) {
                    console.error("Error fetching bagian_jalan options:", error);
                }
            });
        </script>
    
        <script>
            document.addEventListener("DOMContentLoaded", async function () {
                // Inisialisasi Select2 setelah DOM selesai dimuat
                const iri_jalan = $("#bagian_jalan").select({
                    allowClear: true,
                    width: "100%",
                });

                // Fetch data untuk Start KM dan End KM
                try {
                    const response = await fetch("http://localhost:8080/api/get-bagian-iri-options");
                    const data = await response.json();
                    const options = data.data;
                    const bagian_jalan_fragment = document.createDocumentFragment();

                    options.forEach((option) => {
                        const displayText = option.bagian_jalan;
                        const newOption = new Option(displayText, option.bagian_jalan, false, false);
                        bagian_jalan_fragment.appendChild(newOption);
                    });

                    iri_jalan.append(bagian_jalan_fragment).trigger("change");
                } catch (error) {
                    console.error("Error fetching KM options:", error);
                }
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", async function () {
                const iri_jalur = $("#jalur").select({
                    allowClear: true,
                    width: "100%",
                });

                try {
                    const response = await fetch("http://localhost:8080/api/get-jalur-iri-options");
                    const data = await response.json();
                    const options = data.data;
                    const bagian_jalur_fragment = document.createDocumentFragment();

                    options.forEach((option) => {
                        const displayText = option.jalur;
                        const newOption = new Option(displayText, option.jalur, false, false);
                        bagian_jalur_fragment.appendChild(newOption);
                    });

                    iri_jalur.append(bagian_jalur_fragment).trigger("change");
                } catch (error) {
                    console.error("Error fetching jalur options:", error);
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", async function () {
                try {
                    const response = await fetch("http://localhost:8080/api/maintenance");
                    const data = await response.json();
                    const accordion = document.getElementById('recordPemeliharaan');
                    const loading = document.getElementById('recordLoading');
                    if (Array.isArray(data) && data.length > 0) {
                        loading.classList.add('d-none')
                        data.forEach((item, key) => {
                            const accordionItem = document.createElement('div');
                            accordionItem.classList.add('accordion-item');
                            accordionItem.innerHTML = `
                                                                                                            <h2 class="accordion-header">
                                                                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                                                                                    data-bs-target="#collapse${key}" aria-expanded="false" aria-controls="collapse${key}"> 
                                                                                                                    ${item.nama}
                                                                                                                </button>
                                                                                                            </h2>
                                                                                                            <div id="collapse${key}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                                                                                <div class="accordion-body">
                                                                                                                    <p><strong>KM Awal:</strong> ${item.km_awal || 'N/A'}</p>
                                                                                                                    <p><strong>KM Akhir:</strong> ${item.km_akhir || 'N/A'}</p>
                                                                                                                    <p><strong>Jalur:</strong> ${item.jalur || 'N/A'}</p>
                                                                                                                    <p><strong>Bagian Jalan:</strong> ${item.bagian_jalan || 'N/A'}</p>
                                                                                                                    <p><strong>Periode Awal:</strong> ${item.periode_awal || 'N/A'}</p>
                                                                                                                    <p><strong>Periode Akhir:</strong> ${item.periode_akhir || 'N/A'}</p>
                                                                                                                    <p><strong>Jenis Pemeliharaan:</strong> ${item.jenis_pemeliharaan || 'N/A'}</p>
                                                                                                                    <p><strong>Biaya Pemeliharaan:</strong> ${item.biaya_pemeliharaan || 'N/A'}</p>
                                                                                                                    <p><strong>Biaya Impor:</strong> ${item.biaya_impor || 'N/A'}</p>
                                                                                                                    <p><strong>Keterangan Pemeliharaan:</strong> ${item.keterangan_pemeliharaan || 'N/A'}</p>
                                                                                                                    <p><strong>Total Biaya:</strong> ${item.total_biaya || 'N/A'}</p>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        `;
                            accordion.appendChild(accordionItem);
                        });
                    } else {
                        accordion.innerHTML =
                            `<div class="d-none justify-content-center align-items-center" style="height:80%">
                                                                                                <h4>Belum ada data</h4>
                                                                                            </div>`;
                    }
                } catch (error) {
                    console.error("Error fetching jalur options:", error);
                }
            });
        </script>

        <!-- Map config -->
        <script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/map-layer.js') }}"></script>
        <script>
            $(function () {
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            });

            const baseGroupMapsConfig = [
                // {
                //     name: "Ruwasja",
                //     layer: "getRuwasjaPolygonLayer",
                //     legendKey: null
                // },
                // {
                //     name: "Administratif",
                //     layer: "getAdministratifPolygonLayer",
                //     legendKey: null
                // },
                // {
                //     name: "Data Geometrik Jalan",
                //     layer: "getDataGeometrikJalanPolygonLayer",
                //     legendKey: "dataGeometrikJalan"
                // },
                // {
                //     name: "LHR",
                //     layer: "getLHRPolygonLayer",
                //     legendKey: null
                // },
                {
                    name: "IRI",
                    layer: "getIRIPolygonLayer",
                    legendKey: "iri"
                },
                // {
                //     name: "Segmen Tol",
                //     layer: "getSegmenTolPolygonLayer",
                //     legendKey: "segmenTol"
                // },
                // {
                //     name: "Segmen Leger",
                //     layer: "getSegmenLegerPolygonLayer",
                //     legendKey: "segmenLeger"
                // },
                // {
                //     name: "Segmen Perlengkapan",
                //     layer: "getSegmenPerlengkapanPolygonLayer",
                //     legendKey: "segmenPerlengkapan"
                // },
                // {
                //     name: "Segmen Konstruksi",
                //     layer: "getSegmenKonstruksiPolygonLayer",
                //     legendKey: "segmenKonstruksi"
                // },
                // {
                //     name: "Lapis Permukaan",
                //     layer: "getLapisPermukaanPolygonLayer",
                //     legendKey: "lapisPermukaan"
                // },
                // {
                //     name: "Lapis Pondasi Atas 1",
                //     layer: "getLapisPondasiAtas1PolygonLayer",
                //     legendKey: "lapisPondasiAtas1"
                // },
                // {
                //     name: "Lapis Pondasi Atas 2",
                //     layer: "getLapisPondasiAtas2PolygonLayer",
                //     legendKey: "lapisPondasiAtas2"
                // },
                // {
                //     name: "Lapis Pondasi Bawah",
                //     layer: "getLapisPondasiBawahPolygonLayer",
                //     legendKey: "lapisPondasiBawah"
                // },
            ];
            const overlayMapsConfig = [
                // { name: "Jembatan", layer: "getJembatanPolygonLayer" },
                // { name: "Lampu Lalu Lintas", layer: "getLampuLalulintasPointLayer" },
                // { name: "Manhole", layer: "getManholePointLayer" },
                // { name: "Gerbang", layer: "getGerbangPointLayer" },
                // { name: "Patok HM", layer: "getPatokHMPointLayer" },
                // {
                //     name: "Patok KM",
                //     layer: "getPatokKMPointLayer"
                // },
                // { name: "Patok LJ", layer: "getPatokLJPointLayer" },
                // { name: "Patok RMJ", layer: "getPatokRMJPointLayer" },
                // { name: "Patok ROW", layer: "getPatokROWPointLayer" },
                // { name: "Patok Pemandu", layer: "getPatokPemanduPointLayer" },
                // { name: "Reflektor", layer: "getReflektorPointLayer" },
                // { name: "Rambu Lalu Lintas", layer: "getRambuLalulintasPointLayer" },
                // { name: "Rambu Penunjuk Arah", layer: "getRambuPenunjukarahPointLayer" },
                // { name: "Rumah Kabel", layer: "getRumahKabelPointLayer" },
                // { name: "STA Text", layer: "getStaTextPointLayer" },
                // { name: "Tiang Listrik", layer: "getTiangListrikPointLayer" },
                // { name: "Tiang Telepon", layer: "getTiangTeleponPointLayer" },
                // { name: "VMS", layer: "getVMSPointLayer" },
                // { name: "Batas Desa", layer: "getBatasDesaLineLayer" },
                // { name: "Box Culvert", layer: "getBoxCulvertLineLayer" },
                // { name: "Bangunan Penahan Tanah", layer: "getBPTLineLayer" },
                // { name: "Bronjong", layer: "getBronjongLineLayer" },
                // { name: "Concrete Barrier", layer: "getConcreteBarrierLineLayer" },
                // { name: "Gorong Gorong", layer: "getGorongGorongLineLayer" },
                // { name: "Guardrail", layer: "getGuardrailLineLayer" },
                // { name: "Jalan", layer: "getJalanLineLayer" },
                // { name: "Listrik Bawah Tanah", layer: "getListrikBawahtanahLineLayer" },
                // { name: "Marka", layer: "getMarkaLineLayer" },
                // { name: "Pagar Operasional", layer: "getPagarOperasionalLineLayer" },
                // { name: "Pita Kejut", layer: "getPitaKejutLineLayer" },
                // { name: "Riol", layer: "getRiolLineLayer" },
                // { name: "Saluran", layer: "getSaluranLineLayer" },
                // { name: "Sungai", layer: "getSungaiLineLayer" },
                // { name: "Telepon Bawah Tanah", layer: "getTeleponBawahtanahLineLayer" },
            ];

            // Dynamically create layer group objects
            const baseGroupMaps = baseGroupMapsConfig.reduce((acc, {
                name,
                layer,
            }) => {
                acc[name] = window[layer](""); // Dynamically call the layer function
                return acc;
            }, {});

            const overlayMaps = overlayMapsConfig.reduce((acc, {
                name,
                layer
            }) => {
                acc[name] = window[layer](""); // Dynamically call the layer function
                return acc;
            }, {});

            // Map initialization
            const osm_map = L.tileLayer.provider('OpenStreetMap.Mapnik');
            const map = L.map('admin-map', {
                center: [-4.881600, 105.230373],
                zoom: 16,
                layers: [osm_map, baseGroupMaps["IRI"]],
            });

            const layerGroup = L.layerGroup().addTo(map);

            function removeAllLayers() {
                // Hapus semua base layers dari peta
                Object.values(baseGroupMaps).forEach(layer => {
                    if (layer && map.hasLayer(layer)) {
                        map.removeLayer(layer);
                    }
                });

                // Hapus semua overlay layers dari peta
                Object.values(overlayMaps).forEach(layer => {
                    if (layer && map.hasLayer(layer)) {
                        map.removeLayer(layer);
                    }
                });

                // Bersihkan layer group sementara
                layerGroup.clearLayers();
            }

            let layerControl; // Variabel untuk menyimpan kontrol lapisan

            function initializeLayerControl() {
                // Inisialisasi kontrol lapisan saat peta pertama kali dimuat
                layerControl = L.control.layers(baseGroupMaps, overlayMaps).addTo(map);
            }

            function updateMapLayers() {
                const start_km = document.getElementById('start-km').value;
                const end_km = document.getElementById('end-km').value;

                if (!start_km || !end_km) {
                    alert("Silakan pilih rentang KM sebelum menerapkan filter.");
                    return;
                }
                const activeBaseLayers = Object.keys(baseGroupMaps).filter(name => map.hasLayer(baseGroupMaps[name]));
                const activeOverlayLayers = Object.keys(overlayMaps).filter(name => map.hasLayer(overlayMaps[name]));
                // Hapus semua layer dari peta
                removeAllLayers();

                const newBaseGroupMaps = {};
                const newOverlayMaps = {};

                // Perbarui base layers
                baseGroupMapsConfig.forEach(({
                    name,
                    layer
                }) => {
                    const layerFunction = window[layer];
                    if (typeof layerFunction === 'function') {
                        const filteredLayer = layerFunction(start_km, end_km); // Ambil data dari API
                        newBaseGroupMaps[name] = filteredLayer;
                        // Tambahkan layer ke peta jika sebelumnya aktif
                        if (activeBaseLayers.includes(name)) {
                            map.addLayer(filteredLayer);
                        }
                    }
                });

                // Perbarui overlay layers
                overlayMapsConfig.forEach(({
                    name,
                    layer
                }) => {
                    const layerFunction = window[layer];
                    if (typeof layerFunction === 'function') {
                        const filteredLayer = layerFunction(start_km, end_km); // Ambil data dari API
                        newOverlayMaps[name] = filteredLayer;
                        if (activeOverlayLayers.includes(name)) {
                            map.addLayer(filteredLayer);
                        }
                    }
                });
                // Perbarui baseGroupMaps dan overlayMaps dengan layer baru
                Object.keys(baseGroupMaps).forEach(name => {
                    baseGroupMaps[name] = newBaseGroupMaps[name];
                });

                Object.keys(overlayMaps).forEach(name => {
                    overlayMaps[name] = newOverlayMaps[name];
                });
                // Perbarui kontrol lapisan tanpa membuat kontrol baru
                if (layerControl) {
                    layerControl.remove(); // Hapus kontrol lapisan lama dari peta
                }
                layerControl = L.control.layers(baseGroupMaps, overlayMaps).addTo(map);

                console.log("Layers updated with filtered data and layer control refreshed.");
            }

            initializeLayerControl();

            document.getElementById('apply-filter-button').addEventListener('click', function () {
                updateMapLayers();
            });

            const legendsConfig = {
                dataGeometrikJalan: {
                    categories: ["Mainroad", "Ramp", "Akses"],
                    colors: ["#4793AF", "#FFC470", "#DD5746"],
                },
                iri: {
                    categories: ["Baik (< 4)", "Sedang (4-8)", "Rusak Ringan (8-12)", "Rusak Berat (> 12)"],
                    colors: ["#198754", "#ffc107", "#fd7e14", "#dc3545"],
                },
                segmenLeger: {
                    categories: ["Mainroad", "Ramp", "Akses"],
                    colors: ["#4793AF", "#FFC470", "#DD5746"],
                },
                segmenTol: {
                    categories: ["Mainroad", "Ramp", "Akses"],
                    colors: ["#4793AF", "#FFC470", "#DD5746"],
                },
                segmenPerlengkapan: {
                    categories: ["Jalur Kanan", "Jalur Kiri", "Median"],
                    colors: ["#008DDA", "#FF204E", "#FFF455"],
                },
                segmenKonstruksi: {
                    categories: ["Bahu Luar", "Bahu Dalam", "Lajur 1", "Lajur 2", "Lajur Tambahan", "Median"],
                    colors: ["#071952", "#FFB200", "#81A263", "#365E32", "#9CAFAA", "#E4003A"],
                },
                lapisPermukaan: {
                    categories: ["Beton", "AC-BC", "MCB"],
                    colors: ["#009FBD", "#4A249D", "#F9E2AF"],
                },
                lapisPondasiAtas1: {
                    categories: ["AGG-A", "Jembatan", "Lean Concrete"],
                    colors: ["#124076", "#87A922", "#FAA300"],
                },
                lapisPondasiAtas2: {
                    categories: ["AGG-A", "Jembatan", "Box Culvert"],
                    colors: ["#124076", "#87A922", "#EE4266"],
                },
                lapisPondasiBawah: {
                    categories: ["Box Culvert", "Jembatan", "Tanah Pilihan"],
                    colors: ["#114232", "#87A922", "#FCDC2A"],
                },
            };

            // Fungsi untuk membuat legend berdasarkan konfigurasi
            function createLegend(position, {
                categories,
                colors
            }) {
                const legend = L.control({
                    position
                });
                legend.onAdd = function () {
                    const div = L.DomUtil.create("div", "custom-legend");
                    div.innerHTML += '<div class="font-weight-bold">Keterangan:</div>';
                    categories.forEach((category, i) => {
                        div.innerHTML += `<div><i style="background: ${colors[i]}"></i> ${category}</div>`;
                    });
                    return div;
                };
                return legend;
            }

            const legends = Object.keys(legendsConfig).reduce((acc, key) => {
                acc[key] = createLegend('bottomleft', legendsConfig[key]);
                return acc;
            }, {});

            function removeAllLegends() {
                Object.values(legends).forEach(legend => legend.remove(map));
            }


            map.on('overlayadd', function (event) {

                const layerName = event.name;
                console.log(`Overlay added: ${layerName}`);

                // Hapus semua legend sebelum menambahkan yang baru
                removeAllLegends();

                // Cocokkan layer dengan `baseGroupMapsConfig`
                const config = baseGroupMapsConfig.find(config => config.name === layerName);
                if (config && config.legendKey && legends[config.legendKey]) {
                    legends[config.legendKey].addTo(map);
                    console.log(`Legend added for: ${layerName}`);
                } else {
                    console.warn(`No legend found for: ${layerName}`);
                }
            });

            map.on('overlayremove', function (event) {
                const layerName = event.name;

                // Cocokkan layer dengan `baseGroupMapsConfig`
                const config = baseGroupMapsConfig.find(config => config.name === layerName);
                if (config && config.legendKey && legends[config.legendKey]) {
                    legends[config.legendKey].remove();
                    console.log(`Legend removed for: ${layerName}`);
                }
            });
        </script>

        @if (session('success'))
            <script>
                alert("Success sending maintenance record!")
            </script>
        @endif
    @endpush



@endsection