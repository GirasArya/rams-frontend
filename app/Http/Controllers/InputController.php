<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class InputController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('token')) {
                return redirect()->route('login');
            }
            return $next($request);
        });
    }

    public function ruas()
    {
        return view('input.ruas');
    }

    public function storeRuas(Request $request)
    {
        $url = "http://localhost:8080/api/data/input-ruas";
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->post($url, [
            'nama' => $request->nama,
            'kode' => $request->kode,
            'tahun' => $request->tahun
        ]);
        if ($response->successful()) {
            return back()->with('success', "Ruas berhasil ditambahkan");
        } 
        else {
            return back()->with('danger', "Ruas gagal ditambahkan");
        }
    }

    //render view revamp input aset
    public function inputAsetTemp()
    {
        return view('input.aset_temp');
    }

    public function aset(Request $request)
    {
        // Get List Ruas
        $url_list_ruas = "http://localhost:8080/api/data/list-ruas";
        $response_list_ruas = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($url_list_ruas);
        $list_ruas = $response_list_ruas->json();

        // Get Tipe Aset
        $url_tipe_aset = "http://localhost:8080/api/data/tipe-aset";
        $response_tipe_aset = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($url_tipe_aset);
        $tipe_aset = $response_tipe_aset->json();

        return view('input.aset', compact(
            'list_ruas', 
            'tipe_aset'
        ));
    }

    public function storeAset(Request $request)
    {
        $url = "http://localhost:8080/api/data/input-aset";
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->attach(
            'geojson', file_get_contents($request->file('geojson')->getRealPath()), $request->file('geojson')->getClientOriginalName()
        )->post($url, [
            'ruas_id' => $request->ruas_id,
            'tipe_aset' => $request->tipe_aset
        ]);
        if ($response->successful()) {
            return back()->with('success', "Aset berhasil ditambahkan");
        } 
        else {
            $error_message = $response->json()['message'] ?? "Aset gagal ditambahkan";
            return back()->with('danger', $error_message);
        }
    }
}
