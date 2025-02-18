<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request) {
        if(!Auth::check()) { // sudah login atau belum
            return redirect("login");
        }

        $month = $request->query("month");
        $transactions = Transaction::where("user_id", Auth::id())
                                    ->when( $month, function ($query) use ($month ) {
                                            return $query->whereMonth('date', $month );
                                        })
                                    ->orderBy('date','desc')
                                    ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expanse')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions','totalIncome','totalExpense', 'balance', 'month'));
    }

    public function create() {
        if(!Auth::check()) { // sudah login atau belum
            return redirect("login");
        }

        return view('transactions.create');
    }

    public function store(Request $request) {
        if(!Auth::check()) { // sudah login atau belum
            return redirect("login");
        }

        $request->validate([
            'date'=> 'required|date',
            'amount'=> 'required|numeric|min:0',
            'type'=> 'required|in:income,expense',
            'description'=> 'required|string|min:2|max:255',
        ]);


        $request->user()->transactions()->create([
            'date' => $request->date,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Catatan keuangan berhasil disimpan.');
    }


    public function show($id) {
        if(!Auth::check()) { // sudah login atau belum
            return redirect("login");
        }

        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('transactions.show', compact('transaction'));
    }


    public function edit($id) {
        if(!Auth::check()) { // sudah login atau belum
            return redirect("login");
        }

        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('transactions.edit', compact('transaction'));
    }


    public function update(Request $request, $id){
        if(!Auth::check()) { // sudah login atau belum
            return redirect("login");
        }

        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'date' => $request->date,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('transactions.show', $transaction->id)
            ->with('success', 'Transaksi berhasil diperbarui!');
    }


    public function destroy($id) {
        if(!Auth::check()) { // sudah login atau belum
            return redirect("login");
        }

        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Catatan berhasil dihapus.');
    }

}
