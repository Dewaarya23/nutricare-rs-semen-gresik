@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-login">
    <div class="login-form-container p-6 w-full max-w-md">

        <h1 class="text-xl font-bold text-center mb-6">
            Reset Password
        </h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
                class="w-full mb-3 px-3 py-2 rounded">

            <input
                type="password"
                name="password"
                placeholder="Password baru"
                required
                class="w-full mb-3 px-3 py-2 rounded">

            <input
                type="password"
                name="password_confirmation"
                placeholder="Konfirmasi password"
                required
                class="w-full mb-4 px-3 py-2 rounded">

            <button class="w-full bg-blue-600 text-white py-2 rounded">
                Simpan Password
            </button>
        </form>

    </div>
</div>
@endsection
