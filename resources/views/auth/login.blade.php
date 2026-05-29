@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex flex-col bg-cover bg-center"
     style="background-image: url('{{ asset('images/Background_Login.png') }}')">

    {{-- HEADER LOGO --}}
    <div class="relative w-full p-4 z-10">

        <div class="absolute right-4 top-4 flex gap-4 z-30">
            <img src="{{ asset('images/Logo_kemenkes.png') }}" class="h-12 sm:h-14 md:h-16">
            <img src="{{ asset('images/Logo_Akreditasi_RS (2).png') }}" class="h-12 sm:h-14 md:h-16">
        </div>

        <div class="absolute left-1/2 top-16 sm:top-20 md:top-24 transform -translate-x-1/2 z-40">
            <img src="{{ asset('images/Logo_RS_Semen_Gresik (2).png') }}" class="h-28 sm:h-32 md:h-36">
        </div>
    </div>

    {{-- FORM LOGIN --}}
    <div class="flex flex-1 items-start justify-center mt-48 sm:mt-56 md:mt-64 relative z-10">
        <div class="login-form-container login-card-green p-6 sm:p-8 w-full max-w-sm sm:max-w-md md:max-w-lg">

            <h1 class="text-2xl font-bold text-center mb-6">
                Nutricare Rumah Sakit Semen Gresik
            </h1>

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="bg-green-200 text-green-800 p-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-200 text-red-800 p-3 rounded mb-4 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1">Email / Username</label>
                    <input
                        type="text"
                        name="login"
                        placeholder="Masukkan email atau username admin"
                        required
                        class="w-full rounded px-3 py-2">
                </div>

                <div class="mb-3">
                    <label class="block mb-1">Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        class="w-full rounded px-3 py-2">
                </div>


                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">
                    Belum punya akun? Daftar di sini
                </a>
            </div>

        </div>
    </div>

    {{-- MARQUEE INFO --}}
    <div class="bg-blue-900 text-white py-3 overflow-hidden relative z-10">
        <div class="flex marquee whitespace-nowrap text-sm md:text-base font-medium">
            <span class="mx-6">Layanan Paripurna adalah Komitmen Kami</span>
            <span class="text-yellow-300 font-bold">|</span>
            <span class="mx-6">Telp: (031) 3987840-41</span>
            <span class="text-yellow-300 font-bold">|</span>
            <span class="mx-6">IGD 24 Jam: (031) 3971818</span>
            <span class="text-yellow-300 font-bold">|</span>
            <span class="mx-6">Sistem Perhitungan Gizi RS Semen Gresik</span>
            <span class="text-yellow-300 font-bold">|</span>
            <span class="mx-6">Rumah Sakit Semen Gresik - PT Cipta Nirmala</span>
        </div>
    </div>

    <div class="bg-gray-100 text-center text-gray-600 text-sm py-3 border-t relative z-10">
        © {{ date('Y') }} by Rumah Sakit Semen Gresik
    </div>

</div>
@endsection
