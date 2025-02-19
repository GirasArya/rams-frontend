<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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

    public function storeMaintenanceRecord(Request $request)
    {
        $url = "http://127.0.0.1:8080/api/maintenance/store";
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post($url, [
                    'nama' => $request->nama_pemeliharaan,
                    'km_awal' => $request->titik_km_awal,
                    'km_akhir' => $request->titik_km_akhir,
                    'jalur' => $request->jalur,
                    'bagian_jalan' => $request->bagian_jalan,
                    'periode_awal' => $request->periode_awal,
                    'periode_akhir' => $request->periode_akhir,
                    'jenis_pemeliharaan' => $request->jenis_pemeliharaan,
                    'biaya_pemeliharaan' => $request->biaya_pemeliharaan,
                    'biaya_impor' => $request->biaya_impor,
                    'keterangan_pemeliharaan' => $request->keterangan_pemeliharaan,
                    'total_biaya' => $request->biaya_pemeliharaan, 
                ]);

        if ($response->successful()) {
            return redirect()->route('admin.maintenance')->with('success', 'Maintenance record created successfully!');
        } else {
            $errorData = $response->json();
            $errorMessage = "Error creating maintenance record. ";

            if (isset($errorData['message'])) {
                $errorMessage .= $errorData['message']; // Append API error message if available
            } else if ($response->status() == 422) {
                $errorMessage .= "Validation Error. Please check your input.";
            } else {
                $errorMessage .= "Status Code: " . $response->status(); // Include status code for debugging
            }

            return back()->withErrors(['error' => $errorMessage])->withInput(); // Pass error message and repopulate the form
        }
    }
}
