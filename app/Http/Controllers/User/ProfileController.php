<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NutritionTarget;
use Illuminate\Http\Request;
use App\Models\DietLog;
use App\Services\DecisionTreeService;
use App\Services\RuleBasedService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
         /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'jenis_kelamin' => 'required',
            'berat_badan'   => 'required|numeric',
            'tinggi_badan'  => 'required|numeric',
            'tekanan_darah_sistolik' => 'required|numeric|min:1',
            'glukosa_darah' => 'required|numeric|min:1',
            'kolesterol'    => 'required|numeric|min:1',
            'defisit'       => 'required',
            'activity_factor'=> 'required|numeric'
        ]);

        $user->update([
            'jenis_kelamin'  => $request->jenis_kelamin,
            'berat_badan'    => $request->berat_badan,
            'tinggi_badan'   => $request->tinggi_badan,
            'tekanan_darah_sistolik' => $request->tekanan_darah_sistolik,
            'glukosa_darah'  => $request->glukosa_darah,
            'kolesterol'     => $request->kolesterol,
            'defisit'        => $request->defisit,
            'activity_factor'=> $request->activity_factor,
        ]);

    DietLog::where('user_id', $user->id)
    ->whereNull('tanggal_selesai')
    ->update([
        'tanggal_selesai' => now()
    ]);

    $usia = $user->tanggal_lahir
    ? \Carbon\Carbon::parse($user->tanggal_lahir)->age
    : 30;

$tbMeter = $user->tinggi_badan / 100;

$imt = $user->berat_badan / ($tbMeter * $tbMeter);

$bbi = ($user->jenis_kelamin=='L')
    ? ($user->tinggi_badan - 100) * 0.9
    : ($user->tinggi_badan - 100) * 0.85;

$abw = ($imt >= 27)
    ? $bbi + 0.25 * ($user->berat_badan - $bbi)
    : $user->berat_badan;

if($user->jenis_kelamin=='L'){
    $bee = 66 + (13.7*$abw) + (5*$user->tinggi_badan) - (6.8*$usia);
}else{
    $bee = 655 + (9.6*$abw) + (1.8*$user->tinggi_badan) - (4.7*$usia);
}

$tee = $bee * $user->activity_factor;

if($user->defisit=='Menurunkan'){
    $targetKkal = $tee - 400;
}elseif($user->defisit=='Menaikkan'){
    $targetKkal = $tee + 400;
}else{
    $targetKkal = $tee;
}

$targetKarbo   = ($targetKkal * 0.60) / 4;
$targetProtein = ($targetKkal * 0.15) / 4;
$targetLemak   = ($targetKkal * 0.25) / 9;

NutritionTarget::updateOrCreate(
    ['user_id' => $user->id],
    [
        'target_kkal'    => round($targetKkal),
        'target_karbo'   => round($targetKarbo),
        'target_protein' => round($targetProtein),
        'target_lemak'   => round($targetLemak),
    ]
);

    $kategoriDiet = (new DecisionTreeService())->classify(
        glukosaDarah: $user->glukosa_darah,
        tekananDarahSistolik: $user->tekanan_darah_sistolik,
        kolesterol: $user->kolesterol,
        usia: $usia
    );

    $mealPlanId = null;

    if ($kategoriDiet) {
        $rekomendasi = (new RuleBasedService())->recommend(
            $kategoriDiet,
            $user->defisit,
            $targetKkal
        );

        $mealPlanId = $rekomendasi['meal_plan']?->id;
    }

    DietLog::create([
    'user_id' => $user->id,
    'tujuan_diet' => $user->defisit,
    'kategori_diet' => $kategoriDiet,
    'activity_factor' => $user->activity_factor,
    'target_kkal' => $targetKkal,
    'meal_plan_id' => $mealPlanId,
    'tanggal_mulai' => now(),
]);

        return redirect()
            ->route('dashboard.user')
            ->with('success','Profil berhasil disimpan');
    }
}
