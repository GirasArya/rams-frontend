<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
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

    public function index(Request $request)
    {
        $url_dashboard = "http://localhost:8080/api/dashboard";
        $response_dashboard = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->get($url_dashboard);
        $dashboard = $response_dashboard->json();
        // dd($dashboard);

        return view('dashboard', compact('dashboard'));
    }
}
