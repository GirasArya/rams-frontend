<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ManageAsetController extends Controller
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
        // Get Tipe Aset
        $url_tipe_aset = "http://localhost:8080/api/data/tipe-aset";
        $response_tipe_aset = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($url_tipe_aset);
        $tipe_aset = $response_tipe_aset->json();

        return view('manage_aset', compact(
            'tipe_aset'
        ));
    }

    public function inputAsetTemp(Request $request)
    {

        // Get Tipe Aset
        $url_tipe_aset = "http://localhost:8080/api/data/tipe-aset";
        $response_tipe_aset = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($url_tipe_aset);
        $tipe_aset = $response_tipe_aset->json();

        return view('input.aset_temp', compact(
            'tipe_aset'
        ));
    }

    public function storeAssetRecord(Request $request)
    {
        $url = "http://localhost:8080/api/manage/aset/store";
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->attach(
                'geojson',
                file_get_contents($request->file('geojson')->getRealPath()),
                $request->file('geojson')->getClientOriginalName()
            )->post($url, [
                    'id_ruas' => $request->ruas_jalan,
                    'jenis_aset' => $request->jenis_aset,
                    'tanggal_pemasangan' => $request->tanggal_pemasangan
                ]);

        if ($response->successful()) {
            return back()->with('success', "Aset berhasil ditambahkan");
        } else {
            $error_message = $response->json()['message'] ?? "Aset gagal ditambahkan";
            return back()->with('danger', $error_message);
        }
    }
}