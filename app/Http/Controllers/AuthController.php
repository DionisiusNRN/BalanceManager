<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {
            // return redirect("/transactions");
            return redirect()->route('transactions.index');
        }

        // return redirect("login")->with("error_message", "Wrong email or password");
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect("login");
    }

    public function register_form()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Proses pendaftaran (simpan data pengguna ke database)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Setelah registrasi selesai, arahkan ke halaman login
        // return redirect()->route('login')->with('status', 'Registrasi berhasil, silakan login.');
        return redirect("login");
        // return redirect()->route('transactions.index');
    }
}
