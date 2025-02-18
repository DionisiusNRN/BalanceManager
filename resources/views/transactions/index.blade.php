@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Catatan Keuangan</h2>
    <a href="{{ route('transactions.create') }}" class="bg-blue-800 px-4 py-2 rounded hover:bg-blue-600">Add</a>

    <!-- Filter bulan -->
    <div class="flex justify-center mb-6">
        <select onchange="location = this.value;" class="p-2 border rounded-lg bg-black">
            <option value="{{ route('transactions.index') }}" {{ request('month') ? '' : 'selected' }}>All</option>
            @for($m=1; $m<=12; $m++)
                <option value="{{ route('transactions.index', ['month' => $m]) }}"
                    {{ request('month') == $m ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                </option>
            @endfor
        </select>
    </div>

    <!-- Tabel Data -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-black text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-right">Nominal</th>
                    <th class="px-4 py-2 text-center">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2 text-gray-800">{{ date('d M Y', strtotime($transaction->date)) }}</td>
                            <td class="px-4 py-2 text-right font-semibold
                                {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="px-3 py-1 rounded-full text-white
                                    {{ $transaction->type == 'income' ? 'bg-green-600' : 'bg-red-700' }}">
                                    {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('transactions.show', $transaction->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
