<header class="flex justify-between p-5 bg-gray-800 text-white">
    <a href="{{ route('transactions.index') }}">
        <h1 class="text-2xl font-bold">Catatan Keuangan</h1>
    </a>

    <div>
        @if(Auth::check())
            <form action="{{ url("logout") }}" method="POST" class="inline">
                @csrf
                <a href="{{ url("logout") }}" type="button" class="bg-red-600 px-4 py-2 rounded-lg hover:bg-red-700">
                    Logout
                </a>
            </form>
        @else
            <a href="{{ url("login") }}" class="bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">
                Login
            </a>
            <a href="{{ url("register") }}" class="bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600 ml-2">
                Register
            </a>
        @endif
    </div>
</header>
