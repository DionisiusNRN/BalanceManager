<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionController extends Controller
{
    public function index(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
        $month = $request->query("month");

        $transactions = Transaction::where("user_id", $user->id)
                                    ->when($month, fn($query) => $query->whereMonth('date', $month))
                                    ->orderBy('date', 'desc')
                                    ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'transactions' => $transactions,
                'totalIncome' => $transactions->where('type', 'income')->sum('amount'),
                'totalExpense' => $transactions->where('type', 'expense')->sum('amount'),
                'balance' => $transactions->where('type', 'income')->sum('amount') -
                             $transactions->where('type', 'expense')->sum('amount')
            ]
        ]);
    }

    public function store(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'description' => 'required|string|min:2|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'date' => $request->date,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catatan keuangan berhasil disimpan.',
            'data' => $transaction
        ], 201);
    }

    public function show($id) {
        $user = JWTAuth::parseToken()->authenticate();
        $transaction = Transaction::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        return response()->json(['success' => true, 'data' => $transaction]);
    }

    public function update(Request $request, $id) {
        $user = JWTAuth::parseToken()->authenticate();

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $transaction = Transaction::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $transaction->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diperbarui!',
            'data' => $transaction
        ]);
    }

    public function destroy($id) {
        $user = JWTAuth::parseToken()->authenticate();
        $transaction = Transaction::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $transaction->delete();

        return response()->json(['success' => true, 'message' => 'Catatan berhasil dihapus.']);
    }
}
