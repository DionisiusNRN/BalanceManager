@extends('layouts.app')

@section('content')
    <a href="{{ route('transactions.index') }}" class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mb-5 inline-block">
        Kembali
    </a>

    <h1 class="text-xl font-bold mb-4 text-black">Detail Catatan Keuangan</h1>

    <div class="bg-white p-4 rounded-lg shadow-md text-black">
        <p><strong>Tanggal:</strong> {{ $transaction->date }}</p>
        <p><strong>Jumlah:</strong> Rp{{ number_format($transaction->amount, 0, ',', '.') }}</p>
        <p><strong>Jenis:</strong> {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</p>
        <p><strong>Deskripsi:</strong> {{ $transaction->description }}</p>

        <div class="mt-4 space-x-2">
            <a href="{{ route('transactions.edit', $transaction->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                Edit
            </a>

            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Hapus
                </button>
            </form>
        </div>
    </div>
@endsection
