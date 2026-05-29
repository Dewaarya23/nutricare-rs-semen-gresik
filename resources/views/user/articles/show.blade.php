@extends('layouts.user')

@section('content')
<div class="bg-white shadow rounded p-6">
    <h1 class="text-2xl font-bold mb-4">
        {{ $article->judul }}
    </h1>

    @if($article->gambar)
        <img src="{{ asset('storage/'.$article->gambar) }}"
             class="w-full h-72 object-cover rounded mb-4">
    @endif

    <div class="text-gray-700 leading-relaxed">
        {!! nl2br(e($article->isi)) !!}
    </div>
</div>
@endsection
