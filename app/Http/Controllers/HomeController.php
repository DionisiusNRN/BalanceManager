<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('auth.login');

        if (Auth::check()) {
            return redirect()->route('transactions.index'); // Arahkan ke halaman transactions setelah login
        }

        // Kalau belum login, arahkan ke halaman login
        return redirect()->route("login");
    }
}
