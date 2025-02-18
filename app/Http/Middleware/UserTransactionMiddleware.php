<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTransactionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan hanya transaksi milik user yang login yang bisa diakses
        if ($request->route('id') && $request->route('id') != Auth::id()) {
            return redirect('/transactions')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
