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
        return view('manage_aset');
    }

    public function inputAsetTemp()
    {
        return view('input.aset_temp');
    }

    public function storeAssetRecord(Request $request)
    {
        $url = "http://localhost:8080/api/manage/aset/store";
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post($url, [
                    'id_ruas' => $request->ruas_jalan,
                    'jenis_aset' => $request->jenis_aset,
                    'titik_km' => $request->titik_km,
                    'masa_hidup' => $request->masa_hidup,
                    'status' => $request->status,
                    'tanggal_pemasangan' => $request->tanggal_pemasangan,
                ]);

        if ($response->successful()) {
            return redirect()->route('admin.manage_aset')->with('success-store', 'Maintenance record created successfully!');
        } else {

            $errorData = $response->json();
            $errorMessage = "Error creating maintenance record. ";

            if (isset($errorData['message'])) {
                $errorMessage .= $errorData['message'];
            } else if ($response->status() == 422) {
                $errorMessage .= "Validation Error. Please check your input.";
            } else {
                $errorMessage .= "Status Code: " . $response->status();
            }

            return back()->withErrors(['error' => $errorMessage])->withInput();
        }
    }

}