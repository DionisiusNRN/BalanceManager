<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\JWTSubject;


class TransactionController extends Controller
{
    public function index(Request $request) {
        $month = $request->query("month");

        $transactions = Transaction::where("user_id", Auth::id())
                                    ->when($month, function ($query) use ($month) {
                                        return $query->whereMonth('date', $month);
                                    })
                                    ->orderBy('date', 'desc')
                                    ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return response()->json([
            'success' => true,
            'data' => [
                'transactions' => $transactions,
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'balance' => $balance
            ]
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'description' => 'required|string|min:2|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $transaction = $request->user()->transactions()->create($request->all());

        return response()->json(['success' => true, 'message' => 'Catatan keuangan berhasil disimpan.', 'data' => $transaction], 201);
    }

    public function show($id) {
        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json(['success' => true, 'data' => $transaction]);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $transaction->update($request->all());

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil diperbarui!', 'data' => $transaction]);
    }

    public function destroy($id) {
        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $transaction->delete();

        return response()->json(['success' => true, 'message' => 'Catatan berhasil dihapus.']);
    }
}
