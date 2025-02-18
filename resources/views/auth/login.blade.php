@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-gray-500 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-4">Login</h2>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('status'))
        <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
            {{ session('status') }}
        </div>
    @endif


    <form action="{{ url("login") }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" name="email" required class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block">Password:</label>
            <input type="password" name="password" required class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full">
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
            Login
        </button>
    </form>
</div>
@endsection
