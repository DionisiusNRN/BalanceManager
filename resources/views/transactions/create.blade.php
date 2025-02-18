@extends('layouts.app')

@section('content')
    <a href="{{ route('transactions.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mb-5 inline-block">
        &lt; Kembali
    </a>

    <h1 class="text-xl font-bold mb-4">Tambah Catatan Keuangan</h1>

    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Tanggal:</label>
            <input type="date" name="date" required class="border p-2 w-fit">
        </div>

        <div>
            <label class="block">Jumlah:</label>
            <input type="number" name="amount" required class="border p-2 w-fit">
        </div>

        <div>
            <label class="block">Jenis:</label>
            <input type="radio" name="type" value="income" required> Pemasukan
            <input type="radio" name="type" value="expense" required> Pengeluaran
        </div>

        <div>
            <label class="block">Deskripsi:</label>
            <input type="text" name="description" required class="border p-2 w-fit">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
            Simpan
        </button>
    </form>
@endsection
