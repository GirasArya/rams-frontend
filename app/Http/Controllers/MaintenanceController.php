<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Mpdf\Mpdf;

class MaintenanceController extends Controller
{
    // cek session token
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('token')) {
                return redirect()->route('login');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view('maintenance');
    }

    public function maintenanceActivity(Request $request)
    {
        // Get List Ruas
        $url_list_ruas = "http://localhost:8080/api/data/list-ruas";
        $response_list_ruas = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($url_list_ruas);
        $ruas_jalan = $response_list_ruas->json();

        return view(
            'input.aktivitasPemeliharaan',
            compact('ruas_jalan')
        );
    }

    public function storeMaintenanceRecord(Request $request)
    {
        $url = "http://localhost:8080/api/maintenance/store";
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post($url, [
            'nama' => $request->namaRencana,
            'id_ruas' => $request->ruas_jalan,
            'km_awal' => $request->kmAwal,
            'km_akhir' => $request->kmAkhir,
            'jalur' => $request->jalur,
            // 'indeks_iri' => $request->indeksIRI,
            'periode_awal' => $request->periodeAwal,
            'periode_akhir' => $request->periodeAkhir,
            'total_biaya' => 0,
            'detail_aktivitas' => json_decode($request->detail_aktivitas, true)
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.maintenance')->with('success', 'Maintenance record created successfully!');
        } else {
            $error_message = $response->json()['message'] ?? "Aset gagal ditambahkan";
            return back()->with('danger', $error_message);
        }
    }

    public function exportRecord(Request $request)
    {
        $url = "http://localhost:8080/api/maintenance/{$request->id}";
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get($url);
        $data = $response->json();

        $periodeAwal = new DateTime($data['periode_awal']);
        $periodeAkhir = new DateTime($data['periode_akhir']);
        $selisihTahun = (int) $periodeAkhir->format('Y') - (int) $periodeAwal->format('Y');
        $inflasi = 0.05;
        $selisihKM = selisihJarak($data['km_awal'], $data['km_akhir']);
        $totalBiaya = 0;

        $budgetData = []; // Untuk menampung semua perhitungan kegiatan

        $detailAktivitasList = $data['aktivitasKegiatan'] ?? [];

        for ($t = 0; $t <= $selisihTahun; $t++) {
            $tahun = (int) $periodeAwal->format('Y') + $t;

            foreach ($detailAktivitasList as $aktivitas) {
                $anggaranPerMeter = (float) ($aktivitas['anggaran_kegiatan_per_meter'] ?? 0);
                $frekuensi = (float) ($aktivitas['frekuensi_kegiatan_per_tahun'] ?? 0);
                $tenagaKerja = (int) ($aktivitas['jumlah_tenaga_kerja'] ?? 0);

                // Hitung anggaran dengan inflasi
                $anggaranDenganInflasi = $anggaranPerMeter * pow(1 + $inflasi, $t);

                // Hitung total biaya tahunan untuk aktivitas ini
                $biayaTahunan = $anggaranDenganInflasi * $selisihKM * $frekuensi;

                // Tambah ke total keseluruhan
                $totalBiaya += $biayaTahunan;

                // Simpan data
                $budgetData[] = [
                    'tahun' => $tahun,
                    'panjangPemeliharaan' => $selisihKM,
                    'nama_kegiatan' => $aktivitas['nama_kegiatan'] ?? '-',
                    'jenis_pemeliharaan' => $aktivitas['jenis_pemeliharaan'] ?? '-',
                    'frekuensi' => $frekuensi,
                    'anggaran_per_meter_inflasi' => $anggaranDenganInflasi,
                    'jumlah_tenaga_kerja' => $tenagaKerja,
                    'total_biaya_tahunan' => $biayaTahunan,
                ];
            }
        }
        $mpdf = new Mpdf([
            'tempDir' => sys_get_temp_dir(),
            'orientation' => 'L',
            'format' => 'A3',
        ]);
        $mpdf->useSubstitutions = false;

        $html = view('download.templatePemeliharaan', [
            'data' => $data,
            'budgetData' => $budgetData,
            'totalBiaya' => $totalBiaya,
            'selisihKM' => $selisihKM,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output('Record-pemeliharaan.pdf', 'I');
    }
}

function konversiKmToMeter($kmString)
{
    if (empty($kmString)) {
        throw new \Exception("KM input kosong");
    }

    $kmString = str_replace(' ', '', $kmString); // Hapus spasi
    $parts = explode('+', $kmString);

    if (count($parts) !== 2) {
        throw new \Exception("Format KM tidak valid: " . $kmString);
    }

    $km = (int) $parts[0];
    $meterTambahan = (int) $parts[1];

    return ($km * 1000) + $meterTambahan;
}

function selisihJarak($kmAwal, $kmAkhir)
{
    $meterAwal = konversiKmToMeter($kmAwal);
    $meterAkhir = konversiKmToMeter($kmAkhir);

    return abs($meterAkhir - $meterAwal);
}
