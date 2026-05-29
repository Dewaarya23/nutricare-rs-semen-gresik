@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-login">
    <div class="login-form-container p-6 w-full max-w-md">

        <h1 class="text-xl font-bold text-center mb-6">
            Lupa Password
        </h1>

        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <input
                type="email"
                name="email"
                placeholder="Masukkan email"
                required
                class="w-full mb-4 px-3 py-2 rounded">

            <button class="w-full bg-blue-600 text-white py-2 rounded">
                Kirim Link Reset
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="forgot-password">
                Kembali ke Login
            </a>
        </div>

    </div>
</div>
@endsection
