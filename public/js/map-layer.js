var url_api = "http://localhost:8080/api/data/aset/";
var url_api = "http://localhost:8080/api/data/aset/";
var segmen_api = "http://localhost:8080/api/data/segmen/";
var url_icon = location.origin + "/img/map-icons/";


function getAdministratifPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}administratif_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    console.log("admin url: ", fullUrl);
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: "#478CCF",
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Administratif</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Provinsi</span>: ${layer.feature.properties.nama_prov}</div>
                        <div class="mb-1"><span class="font-weight-bold">Kabupaten/Kota</span>: ${layer.feature.properties.nama_kab}</div>
                        <div class="mb-1"><span class="font-weight-bold">Kecamatan</span>: ${layer.feature.properties.nama_kec}</div>
                        <div class="mb-1"><span class="font-weight-bold">Desa</span>: ${layer.feature.properties.nama_desa}</div>
                    </div>
                </div>`;
    });
}

function getDataGeometrikJalanPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}data_geometrik_jalan_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    console.log("geom url: ", fullUrl);
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getDataGeometrikJalanColor(
                    feature.properties.segmen_tol
                ),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Data Geometrik Jalan</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Segmen</span>: ${layer.feature.properties.segmen_tol}</div>
                        <div class="mb-1"><span class="font-weight-bold">Nama Segmen</span>: ${layer.feature.properties.nama}</div>
                        <div class="mb-1">
                            <div class="font-weight-bold mb-1">Data Geometrik:</div>
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <td>Lebar Rumija</td>
                                        <td>${layer.feature.properties.lebar_rmj}</td>
                                    </tr>
                                    <tr>
                                        <td>Gradien Kiri</td>
                                        <td>${layer.feature.properties.gradien_kiri}</td>
                                    </tr>
                                    <tr>
                                        <td>Gradien Kanan</td>
                                        <td>${layer.feature.properties.gradien_kanan}</td>
                                    </tr>
                                    <tr>
                                        <td>Cross Fall Kiri</td>
                                        <td>${layer.feature.properties.cross_fall_kiri}</td>
                                    </tr>
                                    <tr>
                                        <td>Cross Fall Kanan</td>
                                        <td>${layer.feature.properties.cross_fall_kanan}</td>
                                    </tr>
                                    <tr>
                                        <td>Super Elevasi</td>
                                        <td>${layer.feature.properties.super_elevasi}</td>
                                    </tr>
                                    <tr>
                                        <td>Radius</td>
                                        <td>${layer.feature.properties.radius}</td>
                                    </tr>
                                    <tr>
                                        <td>Terrain Kiri</td>
                                        <td>${layer.feature.properties.terrain_kiri}</td>
                                    </tr>
                                    <tr>
                                        <td>Terrain Kanan</td>
                                        <td>${layer.feature.properties.terrain_kanan}</td>
                                    </tr>
                                    <tr>
                                        <td>Tataguna Lahan Kiri</td>
                                        <td>${layer.feature.properties.tataguna_lahan_kiri}</td>
                                    </tr>
                                    <tr>
                                        <td>Tataguna Lahan Kanan</td>
                                        <td>${layer.feature.properties.tataguna_lahan_kanan}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>`;
    });
}

function getDataGeometrikJalanColor(data) {
    switch (data) {
        case "MAIN ROAD":
            return "#4793AF";
        case "RAMP":
            return "#FFC470";
        case "AKSES":
            return "#DD5746";
        default:
            return "black";
    }
}

function getIRIPolygonLayer(start_km="", end_km="") {
    const fullUrl = `${url_api}iri_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    console.log("iri url: ", fullUrl);
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getIRIColor(feature.properties.nilai_iri),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header text-center">
                        ${layer.feature.properties.sgm_tol}
                        ${
                            layer.feature.properties.km !== "-"
                                ? "<br/> KM " + layer.feature.properties.km
                                : ""
                        }
                    </div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Jalur</span>: ${
                            layer.feature.properties.jalur
                        }</div>
                        <div class="mb-1"><span class="font-weight-bold">Bagian Jalan</span>: ${
                            layer.feature.properties.bagian_jalan
                        }</div>
                        <div class="mb-1"><span class="font-weight-bold">Lebar</span>: ${
                            layer.feature.properties.lebar
                        }</div>
                        <div class="mb-1">
                            <div class="font-weight-bold mb-1">Nilai IRI:</div> 
                            <h3 class="text-center font-weight-bold border mb-0">${
                                layer.feature.properties.nilai_iri
                            }</h3>
                        </div>
                    </div>
                </div>`;
    });
}


function getSedangIRILayer(start_km="", end_km="") {
    const fullUrl = `${url_api}iri_sedang?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    console.log("iri url: ", fullUrl);
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getIRIColor(feature.properties.nilai_iri),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header text-center">
                        ${layer.feature.properties.sgm_tol}
                        ${
                            layer.feature.properties.km !== "-"
                                ? "<br/> KM " + layer.feature.properties.km
                                : ""
                        }
                    </div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Jalur</span>: ${
                            layer.feature.properties.jalur
                        }</div>
                        <div class="mb-1"><span class="font-weight-bold">Bagian Jalan</span>: ${
                            layer.feature.properties.bagian_jalan
                        }</div>
                        <div class="mb-1"><span class="font-weight-bold">Lebar</span>: ${
                            layer.feature.properties.lebar
                        }</div>
                        <div class="mb-1">
                            <div class="font-weight-bold mb-1">Nilai IRI:</div> 
                            <h3 class="text-center font-weight-bold border mb-0">${
                                layer.feature.properties.nilai_iri
                            }</h3>
                        </div>
                    </div>
                </div>`;
    });
}

function getRusakRinganIRILayer(start_km="", end_km="") {
    const fullUrl = `${url_api}iri_ringan?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    console.log("iri url: ", fullUrl);
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getIRIColor(feature.properties.nilai_iri),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header text-center">
                        ${layer.feature.properties.sgm_tol}
                        ${
                            layer.feature.properties.km !== "-"
                                ? "<br/> KM " + layer.feature.properties.km
                                : ""
                        }
                    </div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Jalur</span>: ${
                            layer.feature.properties.jalur
                        }</div>
                        <div class="mb-1"><span class="font-weight-bold">Bagian Jalan</span>: ${
                            layer.feature.properties.bagian_jalan
                        }</div>
                        <div class="mb-1"><span class="font-weight-bold">Lebar</span>: ${
                            layer.feature.properties.lebar
                        }</div>
                        <div class="mb-1">
                            <div class="font-weight-bold mb-1">Nilai IRI:</div> 
                            <h3 class="text-center font-weight-bold border mb-0">${
                                layer.feature.properties.nilai_iri
                            }</h3>
                        </div>
                    </div>
                </div>`;
    });
}

function getRusakBeratIRILayer(start_km="", end_km="") {
    const fullUrl = `${url_api}iri_berat?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    console.log("iri url: ", fullUrl);
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getIRIColor(feature.properties.nilai_iri),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header text-center">
                        ${layer.feature.properties.sgm_tol}
                        ${
                            layer.feature.properties.km !== "-"
                                ? "<br/> KM " + layer.feature.properties.km
                                : ""
                        }
                    </div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Jalur</span>: ${
                            layer.feature.properties.jalur
                        }</div>
                        <div class="mb-1"><span class="font-weight-bold">Bagian Jalan</span>: ${
                            layer.feature.properties.bagian_jalan
                        }</div>
                        <div class="mb-1"><span class="font-weight-bold">Lebar</span>: ${
                            layer.feature.properties.lebar
                        }</div>
                        <div class="mb-1">
                            <div class="font-weight-bold mb-1">Nilai IRI:</div> 
                            <h3 class="text-center font-weight-bold border mb-0">${
                                layer.feature.properties.nilai_iri
                            }</h3>
                        </div>
                    </div>
                </div>`;
    });
}

// STANDAR IRI
// IRI < 4: Baik
// IRI 4-8: Sedang
// IRI 8-12: Rusak Ringan
// IRI > 12: Rusak Berat
function getIRIColor(data) {
    return data > 12
        ? "#dc3545"
        : data > 8
        ? "#fd7e14"
        : data > 4
        ? "#ffc107"
        : "#198754";
}

function getJembatanPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}jembatan_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: "#EB5B00",
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Jembatan</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Nama</span>: ${layer.feature.properties.nama}</div>
                        <div class="mb-1"><span class="font-weight-bold">Lokasi</span>: KM ${layer.feature.properties.km}</div>
                        <div class="mb-1"><span class="font-weight-bold">Panjang</span>: ${layer.feature.properties.panjang}</div>
                        <div class="mb-1"><span class="font-weight-bold">Lebar</span>: ${layer.feature.properties.lebar}</div>
                        <div class="mb-1"><span class="font-weight-bold">Luas</span>: ${layer.feature.properties.luas}</div>
                    </div>
                </div>`;
    });
}

function getLapisPermukaanPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}lapis_permukaan_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getLapisPermukaanColor(feature.properties.jenis),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Lapis Permukaan</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Jenis</span>: ${layer.feature.properties.jenis}</div>
                        <div class="mb-1"><span class="font-weight-bold">Tebal</span>: ${layer.feature.properties.tebal}</div>
                    </div>
                </div>`;
    });
}

function getLapisPermukaanColor(data) {
    switch (data) {
        case "BETON":
            return "#009FBD";
        case "AC-BC":
            return "#4A249D";
        case "MCB":
            return "#F9E2AF";
        default:
            return "black";
    }
}

function getLapisPondasiAtas1PolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}lapis_pondasi_atas1_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getLapisPondasiAtas1Color(feature.properties.jenis),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Lapis Pondasi Atas 1</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Jenis</span>: ${layer.feature.properties.jenis}</div>
                        <div class="mb-1"><span class="font-weight-bold">Tebal</span>: ${layer.feature.properties.tebal}</div>
                    </div>
                </div>`;
    });
}

function getLapisPondasiAtas1Color(data) {
    switch (data) {
        case "AGG-A":
            return "#124076";
        case "JEMBATAN":
            return "#87A922";
        case "LEAN CONCRETE":
            return "#FAA300";
        default:
            return "black";
    }
}

function getLapisPondasiAtas2PolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}lapis_pondasi_atas2_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getLapisPondasiAtas2Color(feature.properties.jenis),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Lapis Pondasi Atas 2</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Jenis</span>: ${layer.feature.properties.jenis}</div>
                        <div class="mb-1"><span class="font-weight-bold">Tebal</span>: ${layer.feature.properties.tebal}</div>
                    </div>
                </div>`;
    });
}

function getLapisPondasiAtas2Color(data) {
    switch (data) {
        case "AGG-A":
            return "#124076";
        case "JEMBATAN":
            return "#87A922";
        case "BOX CULVERT":
            return "#EE4266";
        default:
            return "black";
    }
}

function getLapisPondasiBawahPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}lapis_pondasi_bawah_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getLapisPondasiBawahColor(feature.properties.jenis),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Lapis Pondasi Bawah</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Jenis</span>: ${layer.feature.properties.jenis}</div>
                        <div class="mb-1"><span class="font-weight-bold">Tebal</span>: ${layer.feature.properties.tebal}</div>
                    </div>
                </div>`;
    });
}

function getLapisPondasiBawahColor(data) {
    switch (data) {
        case "BOX CULVERT":
            return "#114232";
        case "JEMBATAN":
            return "#87A922";
        case "TANAH PILIHAN":
            return "#FCDC2A";
        default:
            return "black";
    }
}

function getLHRPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}lhr_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;  
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: "#007F73",
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header text-center">Lintas Harian Rata-Rata</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Segmen</span>: ${layer.feature.properties.segmen_tol}</div>
                        <div class="mb-1"><span class="font-weight-bold">Nama Segmen</span>: ${layer.feature.properties.nama_segmen}</div>
                        <div class="mb-1">
                            <div class="font-weight-bold mb-1">Jumlah LHR:</div>
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <td>Gol I</td>
                                        <td>${layer.feature.properties.gol_i}</td>
                                    </tr>
                                    <tr>
                                        <td>Gol II</td>
                                        <td>${layer.feature.properties.gol_ii}</td>
                                    </tr>
                                    <tr>
                                        <td>Gol III</td>
                                        <td>${layer.feature.properties.gol_iii}</td>
                                    </tr>
                                    <tr>
                                        <td>Gol IV</td>
                                        <td>${layer.feature.properties.gol_iv}</td>
                                    </tr>
                                    <tr>
                                        <td>Gol V</td>
                                        <td>${layer.feature.properties.gol_v}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>`;
    });
}

function getRuwasjaPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}ruwasja_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: "#FFDE4D",
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Ruwasja</div>
                    <div class="popup-body">
                        Ruas Bakauheni - Terbanggi Besar
                    </div>
                </div>`;
    });
}

function getSegmenKonstruksiPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}segmen_konstruksi_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getSegmenKonstruksiColor(
                    feature.properties.bagian_jalan
                ),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Segmen Konstruksi</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">Bagian Jalan</span>: ${layer.feature.properties.bagian_jalan}</div>
                        <div class="mb-1"><span class="font-weight-bold">Lebar</span>: ${layer.feature.properties.lebar}</div>
                    </div>
                </div>`;
    });
}

function getSegmenKonstruksiColor(data) {
    switch (data) {
        case "BAHU LUAR":
            return "#071952";
        case "BAHU DALAM":
            return "#FFB200";
        case "LAJUR 1":
            return "#81A263";
        case "LAJUR 2":
            return "#365E32";
        case "LAJUR TAMBAHAN":
            return "#9CAFAA";
        case "MEDIAN":
            return "#E4003A";
        default:
            return "black";
    }
}

const legerRoute = document.getElementById('admin-map').getAttribute('data-route');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function getSegmenLegerPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}segmen_leger_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getSegmenLegerColor(feature.properties.id_leger),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Segmen Leger</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">ID Leger</span>: ${layer.feature.properties.id_leger}</div>
                        <div class="mb-1"><span class="font-weight-bold">Lokasi</span>: KM ${layer.feature.properties.km}</div>
                        <div class="mb-1"><span class="font-weight-bold">Download</span>:
                        <form action="${legerRoute}" method="POST" target="_blank">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" id="leger_id_awal" name="leger_id_awal" value="${layer.feature.properties.id_leger}">
                                <input type="hidden" id="leger_id_akhir" name="leger_id_akhir" value="${layer.feature.properties.id_leger}">
                                <button type="submit" class="btn btn-info btn-sm">
                                    Download
                                </button>
                            </form>
                        </div>
                    </div>
                </div>`;
    });
}

function getSegmenLegerPolygonSelectionLayer(awal, akhir) {
    return new L.GeoJSON.AJAX(segmen_api + awal + "/" + akhir, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getSegmenLegerColor(feature.properties.id_leger),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Segmen Leger</div>
                    <div class="popup-body">
                        <div class="mb-1"><span class="font-weight-bold">ID Leger</span>: ${layer.feature.properties.id_leger}</div>
                        <div class="mb-1"><span class="font-weight-bold">Lokasi</span>: KM ${layer.feature.properties.km}</div>
                    </div>
                </div>`;
    });
}

function getSegmenLegerColor(data) {
    var code = data.substring(0, 1);
    switch (code) {
        case "M":
            return "#4793AF";
        case "R":
            return "#FFC470";
        case "A":
            return "#DD5746";
        default:
            return "black";
    }
}

function getSegmenPerlengkapanPolygonLayer(start_km, end_km) { 
    const fullUrl = `${url_api}segmen_perlengkapan_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getSegmenPerlengkapanColor(feature.properties.jalur),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">Segmen Perlengkapan</div>
                    <div class="popup-body">
                        ${layer.feature.properties.jalur}
                    </div>
                </div>`;
    });
}

function getSegmenPerlengkapanColor(data) {
    switch (data) {
        case "JALUR KANAN":
            return "#008DDA";
        case "JALUR KIRI":
            return "#FF204E";
        case "MEDIAN":
            return "#FFF455";
        default:
            return "black";
    }
}

function getSegmenTolPolygonLayer(start_km, end_km) {
    const fullUrl = `${url_api}segmen_tol_polygon?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        style: function (feature) {
            return {
                weight: 1,
                color: "black",
                fillOpacity: 1,
                fillColor: getSegmenTolColor(feature.properties.segmen_tol),
            };
        },
    }).bindPopup(function (layer) {
        return `<div class="custom-map-popup">
                    <div class="popup-header">${layer.feature.properties.segmen_tol}</div>
                    <div class="popup-body">
                        ${layer.feature.properties.nama_segmen}
                    </div>
                </div>`;
    });
}

function getSegmenTolColor(data) {
    switch (data) {
        case "MAINROAD":
            return "#4793AF";
        case "RAMP":
            return "#FFC470";
        case "AKSES":
            return "#DD5746";
        default:
            return "black";
    }
}

function getLampuLalulintasPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}lampu_lalulintas_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "lampu.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getManholePointLayer(start_km, end_km) {
    const fullUrl = `${url_api}manhole_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "manhole.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getGerbangPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}gerbang_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "gerbang.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getPatokHMPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}patok_hm_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "patok_hm.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getPatokKMPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}patok_km_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "patok_km.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getPatokLJPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}patok_lj_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "patok_lj.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getPatokRMJPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}patok_rmj_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "patok_rmj.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getPatokROWPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}patok_row_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "patok_row.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getPatokPemanduPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}patok_pemandu_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "patok_pemandu.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getReflektorPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}reflektor_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "reflektor.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getRambuLalulintasPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}rambu_lalulintas_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "rambu_lalu_lintas.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getRambuPenunjukarahPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}rambu_penunjukarah_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "rambu_penunjuk_arah.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getRumahKabelPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}rumah_kabel_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "rumah_kabel.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getStaTextPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}sta_text_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "sta_text.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getTiangListrikPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}tiang_listrik_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "listrik.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getTiangTeleponPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}tiang_telepon_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "telepon.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getVMSPointLayer(start_km, end_km) {
    const fullUrl = `${url_api}vms_point?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng, {
                icon: L.icon({
                    iconUrl: url_icon + "vms.png",
                    iconSize: [32, 32],
                }),
            });
        },
    });
}

function getBatasDesaLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}batas_desa_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getBoxCulvertLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}box_culvert_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getBPTLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}bpt_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getBronjongLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}bronjong_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getConcreteBarrierLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}concrete_barrier_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getGorongGorongLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}gorong_gorong_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getGuardrailLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}guardrail_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getJalanLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}jalan_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getListrikBawahtanahLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}listrik_bawahtanah_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getMarkaLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}marka_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getPagarOperasionalLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}pagar_operasional_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getPitaKejutLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}pita_kejut_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getRiolLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}riol_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getSaluranLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}saluran_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getSungaiLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}sungai_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}

function getTeleponBawahtanahLineLayer(start_km, end_km) {
    const fullUrl = `${url_api}telepon_bawahtanah_line?start_km=${start_km || ''}&end_km=${end_km || ''}`;
    return new L.GeoJSON.AJAX(fullUrl);
}
