@extends('layouts.user')

@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Artikel</h1>

{{-- ===== LIVE SEARCH BOX ===== --}}
<div class="mb-6">
    <input type="text"
           id="searchInput"
           placeholder="Cari artikel berdasarkan judul atau ringkasan..."
           class="w-full md:w-1/2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm">
</div>

{{-- ===== CONTAINER ARTIKEL ===== --}}
<div id="articleContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6">

@foreach($articles as $article)
    <div class="bg-white shadow rounded p-4 article-card">
        @if($article->gambar)
        <img src="{{ asset('storage/'.$article->gambar) }}"
             class="w-full h-40 object-cover rounded mb-3">
        @endif

        <p class="text-xs text-gray-500 mb-1">
            {{ \Carbon\Carbon::parse($article->tanggal)->translatedFormat('d F Y') }}
        </p>

        <h3 class="font-semibold">{{ $article->judul }}</h3>

        <p class="text-sm text-gray-600 mt-2">
            {{ $article->ringkasan }}
        </p>

        <a href="{{ route('user.articles.show',$article->id) }}"
           class="text-blue-600 mt-2 inline-block">
           Baca Selengkapnya →
        </a>
    </div>
@endforeach

</div>

{{-- ===== SCRIPT LIVE SEARCH AJAX ===== --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {

    let keyword = this.value;

    fetch("{{ route('user.articles.search') }}?keyword=" + keyword)
        .then(response => response.json())
        .then(data => {

            let container = document.getElementById('articleContainer');
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = `
                    <div class="col-span-3 text-center text-gray-500">
                        Artikel tidak ditemukan.
                    </div>
                `;
                return;
            }

            data.forEach(article => {

                let gambar = article.gambar
                    ? `<img src="/storage/${article.gambar}"
                           class="w-full h-40 object-cover rounded mb-3">`
                    : '';

                container.innerHTML += `
                    <div class="bg-white shadow rounded p-4">
                        ${gambar}

                        <p class="text-xs text-gray-500 mb-1">
                            ${new Date(article.tanggal).toLocaleDateString('id-ID')}
                        </p>

                        <h3 class="font-semibold">${article.judul}</h3>

                        <p class="text-sm text-gray-600 mt-2">
                            ${article.ringkasan}
                        </p>

                        <a href="/user/articles/${article.id}"
                           class="text-blue-600 mt-2 inline-block">
                           Baca Selengkapnya →
                        </a>
                    </div>
                `;
            });

        });

});
</script>

@endsection
