<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mpdf\Mpdf;

set_time_limit(300);

class LegerJalanUtamaController extends Controller
{

    public function legerViewSelect(Request $request)
    {
        $api = "http://localhost:8080/api/leger/ruas";
        $data = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($api);
        $data = $data->json();
        return view('leger.jalan-utama.leger-view-select', compact('data'));
    }

    public function legerEditSelect(Request $request)
    {
        $api = "http://localhost:8080/api/leger/ruas";
        $data = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($api);
        $data = $data->json();
        return view('leger.jalan-utama.leger-edit-select', compact('data'));
    }



    public function legerViewDetail(Request $request)
    {
        $api = "http://localhost:8080/api/leger/segmen/{$request->jalan_tol_id}";
        $data = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($api);

        $data = $data->json();
        $jalan_tol_id = $request->jalan_tol_id;
        return view('leger.jalan-utama.leger-view-detail', compact('data', 'jalan_tol_id'));
    }

    public function legerEditDetail(Request $request)
    {
        $api_segmen = "http://localhost:8080/api/leger/segmen/{$request->jalan_tol_id}";
        $api_leger = "http://localhost:8080/api/leger/jalan-utama-all/{$request->jalan_tol_id}";

        $data_segmen = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($api_segmen);

        $data_leger = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($api_leger);

        $data_segmen = $data_segmen->json();
        $data_leger = $data_leger->json();
        $jalan_tol_id = $request->jalan_tol_id;
        return view('leger.jalan-utama.leger-edit-detail', compact('data_segmen', 'data_leger', 'jalan_tol_id'));
    }

    public function legerGenerate(Request $request)
    {
        $api = "http://localhost:8080/api/leger/populate/{$request->jalan_tol_id}";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token'),
        ])->get($api);

        if ($response->successful()) {
            $status = [
                'type' => 'success',
                'message' => 'Leger data generated successfully!',
            ];
        } else {
            $status = [
                'type' => 'error',
                'message' => 'Failed to generate leger data. ' . $response->body(),
            ];
        }
        return redirect()->route('admin.leger.jalanUtama.edit.select')->with('status', $status);
    }

    public function legerPrint(Request $request)
    {
        $url = "http://localhost:8080/api/leger/jalan-utama/{$request->jalan_tol_id}/{$request->leger_id_awal}/{$request->leger_id_akhir}";
        $data = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($url);
        $data = $data->json();

        $mpdf = new Mpdf(['tempDir' => __DIR__ . '/../../../public/temp/', 'orientation' => 'L', 'format' => 'A3']);
        $mpdf->useSubstitutions = false;
        $totalPages = count($data);

        foreach ($data as $index => $page) {
            $html = view('download.templateLegerJalan', ['data' => $page]);
            $mpdf->writeHTML($html);
            $mpdf->AddPage();
            $html_img = view('download.templateLegerJalanBelakang');
            $mpdf->writeHTML($html_img);
            if ($index < $totalPages - 1) {
                $mpdf->AddPage();
            }
        }
        $mpdf->Output('Leger Kartu Jalan Utama Test.pdf', 'I');
    }
}
