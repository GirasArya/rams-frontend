<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Session::has('token')) {
                return redirect()->route('dashboard');
            }
            return $next($request);
        })->except('logout');
    }

    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $url = "http://localhost:8080/api/login";
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post($url, [
            'email' => $request->email,
            'password' => $request->password
        ]);
        if ($response->successful()) {
            $request->session()->put('nama', $response->json()['nama']);
            $request->session()->put('token', $response->json()['token']);
            return redirect()->route('dashboard');
        } 
        else {
            return back()->withErrors(['error' => "Email atau Password salah"]);
        }
    }

    public function logout(Request $request)
    {
        $url = "http://localhost:8080/api/logout";
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $request->session()->get('token')
        ])->post($url);
        $request->session()->flush();
        return redirect()->route('login');
    }
}
