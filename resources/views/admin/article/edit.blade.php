@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Edit Artikel</h1>
    <p class="text-gray-600 text-sm">Ubah data artikel</p>
</div>

<div class="bg-white shadow rounded-xl p-6">
    <form action="{{ route('admin.articles.update', $article->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-semibold">Judul</label>
                <input type="text"
                       name="judul"
                       value="{{ old('judul', $article->judul) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400 outline-none"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       value="{{ old('tanggal', $article->tanggal) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400 outline-none"
                       required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold">Ringkasan</label>
                <textarea name="ringkasan"
                          rows="3"
                          class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400 outline-none"
                          required>{{ old('ringkasan', $article->ringkasan) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold">Isi Lengkap</label>
                <textarea name="isi"
                          rows="6"
                          class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400 outline-none"
                          required>{{ old('isi', $article->isi) }}</textarea>
            </div>

            {{-- ===== BAGIAN GAMBAR MODERN + LIVE PREVIEW ===== --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-3">Gambar Artikel</label>

                <div class="relative w-full max-w-md mb-4">
                    <img id="previewImage"
                         src="{{ $article->gambar ? asset('storage/'.$article->gambar) : 'https://via.placeholder.com/600x350?text=Belum+Ada+Gambar' }}"
                         class="rounded-xl shadow-md w-full object-cover transition duration-300">

                    @if($article->gambar)
                    <button type="submit"
                            name="hapus_gambar"
                            value="1"
                            class="absolute top-3 right-3 bg-red-600 text-white px-3 py-1 text-xs rounded-full hover:bg-red-700 transition">
                        🗑 Hapus
                    </button>
                    @endif
                </div>

                <label class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-blue-700 transition">
                    Ganti / Upload Gambar
                    <input type="file"
                           name="gambar"
                           id="gambarInput"
                           class="hidden"
                           accept="image/*">
                </label>

                <p class="text-xs text-gray-400 mt-2">
                    Format: JPG, PNG. Maksimal 2MB.
                </p>
            </div>

        </div>

        <div class="mt-6 flex gap-3">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                Update Artikel
            </button>

            <a href="{{ route('admin.articles.index') }}"
               class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition">
                Batal
            </a>
        </div>
    </form>
</div>

{{-- ===== SCRIPT LIVE PREVIEW ===== --}}
<script>
document.getElementById('gambarInput').addEventListener('change', function(event) {

    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
        }

        reader.readAsDataURL(file);
    }
});
</script>

@endsection
