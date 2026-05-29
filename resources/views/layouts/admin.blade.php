<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title','Dashboard Admin')</title>

    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100 text-base overflow-x-hidden">

<div class="flex min-h-screen w-full">

    @include('partials.admin.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        @include('partials.admin.topbar')

        <main class="flex-1 p-4 md:p-6 overflow-x-auto">

            {{-- NOTIFIKASI GLOBAL --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

{{-- JQUERY --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- SCRIPT GLOBAL --}}
<script>
function hapus(id) {
    if (!confirm('Yakin ingin menghapus data ini?')) return;

    fetch(`/admin/diseases/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal menghapus data');
        }
    })
    .catch(() => alert('Terjadi kesalahan server'));
}
</script>

@stack('scripts')

</body>
</html>
