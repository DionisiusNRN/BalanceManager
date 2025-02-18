{{-- app itu hanya sebagai template aja --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MovieApp</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-400 text-white">
    {{-- menampilkan content dari file _header --}}
    @include('layouts.app.header')

    <section class="container mx-auto p-5">
        {{-- yield: supaya isi contentnya bisa berubah-ubah --}}
        @yield('content')
    </section>
</body>
</html>
