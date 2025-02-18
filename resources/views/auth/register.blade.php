@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-gray-500 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-4">Register</h2>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ url("register") }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block">Nama:</label>
            <input type="text" name="name" required class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" name="email" required class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block">Password:</label>
            <input type="password" name="password" required class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block">Konfirmasi Password:</label>
            <input type="password" name="password_confirmation" required class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 w-full">
            Register
        </button>
    </form>
</div>
@endsection
