@extends('layouts/app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Aset</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage Aset</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div id="admin-map" data-route="{{ route('admin.leger.jalanUtama.generate') }}" style="height: 250px"></div>
        </div>
    </section>

    <section class="content">
        <div class="card mb-4">
            <div class="card-header">Data Aset</div>
            <div class="card-body">
                <form id="filterAsset" class="d-flex justify-content-between">
                    <section class="pb-2 d-flex justify-content-around" style="gap: 2rem">
                        <select aria-placeholder="Filter Jenis Aset" id="jenis_aset" class="form-select">
                            <option value="" disabled selected>Filter Jenis Aset</option>
                            <option value="Patok KM">Patok KM</option>
                            {{-- <option value=""></option> --}}
                            {{-- <option value=""></option> --}}
                        </select>

                        <select aria-placeholder="Filter status" id="status" class="form-select">
                            <option value="" disabled selected>Filter Status</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>

                        <div id="Tanggal" class="input-group" style="width: fit-content">
                            <input id="tanggal_pemasangan" placeholder="Tanggal Pemasangan" type="date"
                                class="form-control" placeholder="Tanggal Pemasangan" aria-label="Tanggal Pemasangan"
                                aria-describedby="basic-addon1">
                        </div>
                    </section>
                    <section>
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        <a href="{{ route('input.aset-temp') }}" class="btn btn-success">
                            Tambah Aset
                        </a>
                    </section>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Jenis Aset</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Masa Hidup</th>
                            <th scope="col">Status Kondisi</th>
                            <th scope="col">Tanggal Pemasangan (dd/mm/yyyy)</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <section id="recordLoading" class="pt-4 d-flex align-items-center justify-content-center h-100">
                    <div class="spinner-grow" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </section>
                {{-- <p class="d-flex justify-content-center pt-4">Tidak ada Data</p> --}}
            </div>
        </div>
    </section>

    @push('scripts')
        {{-- GET Data aset and render --}}
        <script>
            document.addEventListener("DOMContentLoaded", async function() {
                try {
                    const response = await fetch(
                        "http://localhost:8080/api/manage/aset");
                    const data = await response.json();
                    const tbody = document.querySelector('.table tbody');
                    const loading = document.getElementById('recordLoading');
                    if (data.length === 0) {
                        loading.classList.add('d-none');
                        const noDataMessage = document.createElement('p');
                        noDataMessage.textContent = 'Belum ada data';
                        noDataMessage.classList.add('d-flex', 'justify-content-center');
                        tbody.appendChild(noDataMessage);
                    } else {
                        loading.classList.add('d-none');
                        data.forEach(item => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <td>${item.jenis_aset}</td>
                            <td>${item.titik_km}</td> 
                            <td>${item.masa_hidup} Tahun</td>
                            <td>${item.status}</td>
                            <td>${new Date(item.tanggal_pemasangan).toLocaleDateString('id-ID')}</td> 
                            <td>
                                <button class="btn btn-sm btn-danger">Delete</button> 
                            </td>
                            `;
                            tbody.appendChild(row);
                        });
                    }
                } catch (error) {
                    console.error("Error fetching aset data:", error);
                }
            });
        </script>

        <script>
            const filterAssetForm = document.getElementById('filterAsset');
            const loading = document.getElementById('recordLoading');
            const tbody = document.querySelector('.table tbody');
            const noDataMessage = document.createElement('td');

            filterAssetForm.addEventListener("submit", async function(event) {
                event.preventDefault();
                loading.classList.remove('d-none');
                tbody.innerHTML = '';

                const jenis_aset = document.getElementById('jenis_aset').value;
                const statusOption = document.getElementById('status').value;
                const tanggal_pemasangan = document.getElementById('tanggal_pemasangan').value;

                const queryParams = new URLSearchParams();
                if (jenis_aset) {
                    queryParams.append('jenis_aset', jenis_aset);
                }
                if (statusOption) {
                    queryParams.append('status', statusOption);
                }
                if (tanggal_pemasangan) {
                    queryParams.append('tanggal_pemasangan', tanggal_pemasangan);
                }

                const url = `http://localhost:8080/api/manage/aset/filter?${queryParams.toString()}`;

                console.log(tanggal_pemasangan);
                console.log(url);

                try {
                    const response = await fetch(url);
                    const data = await response.json();

                    if (data.length === 0) {
                        loading.classList.add('d-none');
                        tbody.innerHTML = '';

                        noDataMessage.textContent = 'Belum ada data';
                        noDataMessage.colSpan = "9";
                        noDataMessage.classList.add('d-flex', 'justify-content-center');
                        tbody.appendChild(noDataMessage);
                    } else {
                        data.forEach(item => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${item.jenis_aset}</td>
                        <td>${item.titik_km}</td> 
                        <td>${item.masa_hidup} Tahun</td>
                        <td>${item.status}</td>
                        <td>${new Date(item.tanggal_pemasangan).toLocaleDateString('id-ID')}</td> 
                        <td>
                            <button class="btn btn-sm btn-danger deleteButton" data-id="${item.id}">Delete</button> 
                        </td>
                    `;
                            tbody.appendChild(row);
                        });
                    }
                } catch (error) {
                    console.error("Error fetching aset data:", error);
                } finally {
                    loading.classList.add('d-none');
                }
            });
        </script>


        <script src="{{ asset('js/map-layer.js') }}"></script>
        <script>
            $(function() {
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
                {
                    name: "LHR",
                    layer: "getLHRPolygonLayer",
                    legendKey: null
                },
                // {
                //     name: "IRI",
                //     layer: "getIRIPolygonLayer",
                //     legendKey: "iri"
                // },
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
            const overlayMapsConfig = [{
                    name: "Jembatan",
                    layer: "getJembatanPolygonLayer"
                },
                {
                    name: "Lampu Lalu Lintas",
                    layer: "getLampuLalulintasPointLayer"
                },
                {
                    name: "Manhole",
                    layer: "getManholePointLayer"
                },
                {
                    name: "Gerbang",
                    layer: "getGerbangPointLayer"
                },
                {
                    name: "Patok HM",
                    layer: "getPatokHMPointLayer"
                },
                {
                    name: "Patok KM",
                    layer: "getPatokKMPointLayer"
                },
                {
                    name: "Patok LJ",
                    layer: "getPatokLJPointLayer"
                },
                {
                    name: "Patok RMJ",
                    layer: "getPatokRMJPointLayer"
                },
                {
                    name: "Patok ROW",
                    layer: "getPatokROWPointLayer"
                },
                {
                    name: "Patok Pemandu",
                    layer: "getPatokPemanduPointLayer"
                },
                {
                    name: "Reflektor",
                    layer: "getReflektorPointLayer"
                },
                {
                    name: "Rambu Lalu Lintas",
                    layer: "getRambuLalulintasPointLayer"
                },
                // { name: "Rambu Penunjuk Arah", layer: "getRambuPenunjukarahPointLayer" },
                // { name: "Rumah Kabel", layer: "getRumahKabelPointLayer" },
                {
                    name: "STA Text",
                    layer: "getStaTextPointLayer"
                },
                // { name: "Tiang Listrik", layer: "getTiangListrikPointLayer" },
                // { name: "Tiang Telepon", layer: "getTiangTeleponPointLayer" },
                {
                    name: "VMS",
                    layer: "getVMSPointLayer"
                },
                // { name: "Batas Desa", layer: "getBatasDesaLineLayer" },
                {
                    name: "Box Culvert",
                    layer: "getBoxCulvertLineLayer"
                },
                {
                    name: "Bangunan Penahan Tanah",
                    layer: "getBPTLineLayer"
                },
                {
                    name: "Bronjong",
                    layer: "getBronjongLineLayer"
                },
                {
                    name: "Concrete Barrier",
                    layer: "getConcreteBarrierLineLayer"
                },
                {
                    name: "Gorong Gorong",
                    layer: "getGorongGorongLineLayer"
                },
                // { name: "Guardrail", layer: "getGuardrailLineLayer" },
                // { name: "Jalan", layer: "getJalanLineLayer" },
                // { name: "Listrik Bawah Tanah", layer: "getListrikBawahtanahLineLayer" },
                {
                    name: "Marka",
                    layer: "getMarkaLineLayer"
                },
                {
                    name: "Pagar Operasional",
                    layer: "getPagarOperasionalLineLayer"
                },
                {
                    name: "Pita Kejut",
                    layer: "getPitaKejutLineLayer"
                },
                {
                    name: "Riol",
                    layer: "getRiolLineLayer"
                },
                // { name: "Saluran", layer: "getSaluranLineLayer" },
                // { name: "Sungai", layer: "getSungaiLineLayer" },
                {
                    name: "Telepon Bawah Tanah",
                    layer: "getTeleponBawahtanahLineLayer"
                },
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
                layers: [osm_map, baseGroupMaps["LHR"]],
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

            document.getElementById('apply-filter-button').addEventListener('click', function() {
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
                legend.onAdd = function() {
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


            map.on('overlayadd', function(event) {

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

            map.on('overlayremove', function(event) {
                const layerName = event.name;

                // Cocokkan layer dengan `baseGroupMapsConfig`
                const config = baseGroupMapsConfig.find(config => config.name === layerName);
                if (config && config.legendKey && legends[config.legendKey]) {
                    legends[config.legendKey].remove();
                    console.log(`Legend removed for: ${layerName}`);
                }
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Inisialisasi Select2 setelah DOM selesai dimuat
                const startKmSelect = $("#start-km").select2({
                    placeholder: "Select Start KM",
                    allowClear: true,
                    theme: "bootstrap-5",
                    width: "100%",
                });

                const endKmSelect = $("#end-km").select2({
                    placeholder: "Select End KM",
                    allowClear: true,
                    theme: "bootstrap-5",
                    width: "100%",
                });

                // Fetch data untuk Start KM dan End KM
                fetch("http://localhost:8080/api/get-km-options")
                    .then((response) => response.json())
                    .then((data) => {
                        const options = data.data; // Asumsi API mengembalikan { "data": [...] }
                        options.forEach((option) => {
                            const displayText = option.km; // Teks yang ditampilkan
                            const newOption = new Option(displayText, option.km, false,
                                false); // Opsi untuk Select2
                            startKmSelect.append(newOption).trigger("change"); // Tambahkan ke Start KM
                            endKmSelect.append(newOption.cloneNode(true)).trigger(
                                "change"); // Tambahkan ke End KM
                        });
                    })
                    .catch((error) => {
                        console.error("Error fetching KM options:", error);
                    });

                // Handle button Apply Filter
                document.getElementById("apply-filter-button").addEventListener("click", function() {
                    const startKm = $("#start-km").val(); // Nilai Start KM
                    const endKm = $("#end-km").val(); // Nilai End KM

                    if (!startKm || !endKm) {
                        alert("Please select both Start KM and End KM!");
                        return;
                    }

                    console.log(`Filter applied with Start KM: ${startKm}, End KM: ${endKm}`);
                    // Implementasikan logika filter pada map di sini...
                });
            });
        </script>
    @endpush
@endsection
