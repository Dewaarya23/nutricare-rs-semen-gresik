@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Entry Artikel</h1>
    <p class="text-gray-600 text-sm">Manajemen konten artikel edukasi gizi</p>
</div>


{{-- FORM POSTING --}}
<div class="bg-white shadow rounded p-6 mb-8">
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium">Judul</label>
                <input type="text" name="judul" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Entri</label>
                <input type="date" name="tanggal" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Ringkasan</label>
                <textarea name="ringkasan" rows="3" class="w-full border rounded px-3 py-2 mt-1" required></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Isi Lengkap</label>
                <textarea name="isi" rows="6" class="w-full border rounded px-3 py-2 mt-1" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Gambar</label>
                <input type="file" name="gambar" class="w-full mt-1">
            </div>

        </div>

        <div class="mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Posting Artikel
            </button>
        </div>

    </form>
</div>

{{-- HISTORY ARTIKEL --}}
<div class="bg-white shadow rounded p-6">
    <h2 class="text-lg font-semibold mb-4">History Artikel</h2>

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">No</th>
                <th class="border px-3 py-2">Judul</th>
                <th class="border px-3 py-2">Tanggal</th>
                <th class="border px-3 py-2">Ringkasan</th>
                <th class="border px-3 py-2">Opsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $i => $article)
            <tr>
                <td class="border px-3 py-2">{{ $i+1 }}</td>
                <td class="border px-3 py-2">{{ $article->judul }}</td>
                <td class="border px-3 py-2">{{ $article->tanggal }}</td>
                <td class="border px-3 py-2">{{ $article->ringkasan }}</td>
                <td class="border px-3 py-2">

                    <div class="flex gap-2 justify-center">

                        {{-- VIEW --}}
                        <a href="{{ route('admin.articles.show', $article->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                            View
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('admin.articles.edit', $article->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                            Edit
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.articles.destroy',$article->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">
                                Delete
                            </button>
                        </form>

                    </div>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">
                    Belum ada artikel.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
