<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Disease;
use App\Models\DietLog;
use App\Models\NutritionTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register', [
            'diseases' => Disease::all()
        ]);
    }

public function store(Request $request)
{
    $request->validate([
        'username'              => 'required|email|unique:users,email',
        'password'              => 'required|min:6',
        'nama'                  => 'required|string|max:255',
        'tanggal_lahir'         => 'required|date',
        'no_telp'               => 'required|string|max:255',
        'jenis_kelamin'         => 'required|in:L,P',
        'berat_badan'           => 'required|numeric|min:1',
        'tinggi_badan'          => 'required|numeric|min:1',
        'defisit'               => 'required|in:Menurunkan,Stabil,Menaikkan',
        'activity_factor'       => 'required|numeric',
        'ada_riwayat'           => 'required|in:ya,tidak',
        'riwayat_penyakit'      => 'nullable|array',
        'riwayat_penyakit.*'    => 'exists:diseases,id',
    ]);

    $user = User::create([
        'name'           => $request->nama,
        'email'          => $request->username,
        'password'       => Hash::make($request->password),
        'nama'           => $request->nama,
        'tanggal_lahir'  => $request->tanggal_lahir,
        'no_telp'        => $request->no_telp,
        'jenis_kelamin'  => $request->jenis_kelamin,
        'berat_badan'    => $request->berat_badan,
        'tinggi_badan'   => $request->tinggi_badan,
        'ada_riwayat'    => $request->ada_riwayat,
        'defisit'        => $request->defisit,
        'activity_factor'=> $request->activity_factor,
        'role'           => 'user',
    ]);

    /* ================================
       HITUNG TARGET GIZI OTOMATIS
    ================================= */

    $usia = \Carbon\Carbon::parse($request->tanggal_lahir)->age;

$tbMeter = $request->tinggi_badan / 100;

$imt = $request->berat_badan / ($tbMeter * $tbMeter);

$bbi = ($request->jenis_kelamin == 'L')
    ? ($request->tinggi_badan - 100) * 0.9
    : ($request->tinggi_badan - 100) * 0.85;

$abw = ($imt >= 27)
    ? $bbi + 0.25 * ($request->berat_badan - $bbi)
    : $request->berat_badan;

if ($request->jenis_kelamin == 'L') {

    $bee = 66
        + (13.7 * $abw)
        + (5 * $request->tinggi_badan)
        - (6.8 * $usia);

} else {

    $bee = 655
        + (9.6 * $abw)
        + (1.8 * $request->tinggi_badan)
        - (4.7 * $usia);
}

$tee = $bee * $request->activity_factor;

if ($request->defisit == 'Menurunkan') {

    $targetKkal = $tee - 400;

} elseif ($request->defisit == 'Menaikkan') {

    $targetKkal = $tee + 400;

} else {

    $targetKkal = $tee;
}

$targetKarbo   = ($targetKkal * 0.60) / 4;
$targetProtein = ($targetKkal * 0.15) / 4;
$targetLemak   = ($targetKkal * 0.25) / 9;

    NutritionTarget::create([
        'user_id'        => $user->id,
        'target_kkal'    => $targetKkal,
        'target_karbo'   => $targetKarbo,
        'target_protein' => $targetProtein,
        'target_lemak'   => $targetLemak,
    ]);

    DietLog::create([
        'user_id' => $user->id,
        'tujuan_diet' => $request->defisit,
        'activity_factor' => $request->activity_factor,
        'target_kkal' => $targetKkal,
        'tanggal_mulai' => now(),
    ]);

    /* ================================
       SYNC RIWAYAT PENYAKIT
    ================================= */

    if ($request->ada_riwayat === 'ya' && $request->filled('riwayat_penyakit')) {
        $user->diseases()->sync($request->riwayat_penyakit);
    }

    return redirect('/login')
        ->with('success', 'Registrasi berhasil. Silakan login.');
}
}
