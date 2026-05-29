@extends('layouts.admin')

@section('title','Profile Admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Edit Foto Profil</h1>

<form action="{{ route('admin.profile.update') }}"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow w-96">

    @csrf

    <div class="mb-4">
        <label class="block mb-2 text-sm font-medium">Upload Foto</label>
        <input type="file" name="photo" class="w-full border p-2 rounded">
        @error('photo')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Simpan
    </button>

</form>

@endsection
