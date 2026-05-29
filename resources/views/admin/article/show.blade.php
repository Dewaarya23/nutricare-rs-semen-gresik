@extends('layouts.admin')

@section('title','Detail Artikel')

@section('content')

<h1 class="text-2xl font-bold mb-6">Detail Artikel</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-3">
        {{ $article->judul }}
    </h2>

    <p class="text-sm text-gray-500 mb-4">
        {{ $article->tanggal }}
    </p>

    @if($article->gambar)
        <img src="{{ asset('storage/'.$article->gambar) }}"
             class="w-full max-w-md mb-4 rounded">
    @endif

    <p class="text-gray-700 mb-4">
        {{ $article->ringkasan }}
    </p>

    <div class="text-gray-800">
        {!! nl2br(e($article->isi)) !!}
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.articles.index') }}"
           class="text-blue-600 underline">
            ← Kembali
        </a>
    </div>

</div>

@endsection
