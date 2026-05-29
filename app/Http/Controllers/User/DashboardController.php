<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Models\DietLog;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $imt = null;
        $bbi = null;
        $targetKkal = 0;
        $targetProtein = 0;
        $targetLemak = 0;
        $targetKarbo = 0;

        $imtKategori = null;
        $imtColor = null;

        if ($user && $user->berat_badan && $user->tinggi_badan) {

            $usia = $user->tanggal_lahir
                ? \Carbon\Carbon::parse($user->tanggal_lahir)->age
                : 30;

            $tbMeter = $user->tinggi_badan / 100;
            $imt = $user->berat_badan / ($tbMeter * $tbMeter);

            if ($imt < 18.5) {
                $imtKategori = "Kurus";
                $imtColor = "text-orange-500";
            } elseif ($imt < 23) {
                $imtKategori = "Normal";
                $imtColor = "text-green-600";
            } elseif ($imt < 25) {
                $imtKategori = "Overweight";
                $imtColor = "text-yellow-500";
            } elseif ($imt < 30) {
                $imtKategori = "Obesitas I";
                $imtColor = "text-orange-500";
            } elseif ($imt < 35) {
                $imtKategori = "Obesitas II";
                $imtColor = "text-orange-500";
            } else {
                $imtKategori = "Obesitas III";
                $imtColor = "text-red-600";
            }

            $bbi = ($user->jenis_kelamin == 'L')
                ? ($user->tinggi_badan - 100) * 0.9
                : ($user->tinggi_badan - 100) * 0.85;

            $abw = ($imt >= 27)
                ? $bbi + 0.25 * ($user->berat_badan - $bbi)
                : $user->berat_badan;

            if ($user->jenis_kelamin == 'L') {
                $bee = 66 + (13.7 * $abw) + (5 * $user->tinggi_badan) - (6.8 * $usia);
            } else {
                $bee = 655 + (9.6 * $abw) + (1.8 * $user->tinggi_badan) - (4.7 * $usia);
            }

            $activityFactor = $user->activity_factor ?? 1.3;

            $tee = $bee * $activityFactor;

            if ($user->defisit == 'Menurunkan') {
                $targetKkal = $tee - 400;
            } elseif ($user->defisit == 'Menaikkan') {
                $targetKkal = $tee + 400;
            } else {
                $targetKkal = $tee;
            }

            $targetKkal = round($targetKkal);

            if ($user->defisit == 'Menurunkan') {
                $targetProtein = round((0.17 * $targetKkal) / 4);
                $targetKarbo   = round((0.58 * $targetKkal) / 4);
            } else {
                $targetProtein = round((0.15 * $targetKkal) / 4);
                $targetKarbo   = round((0.60 * $targetKkal) / 4);
            }

            $targetLemak = round((0.25 * $targetKkal) / 9);
        }

        // =====================================================
// NONAKTIFKAN OVERRIDE DARI DATABASE
// AGAR DASHBOARD SELALU HITUNG OTOMATIS SEPERTI EXCEL
// =====================================================

// if ($user && $user->nutritionTarget) {
//     $targetKkal    = $user->nutritionTarget->target_kkal;
//     $targetProtein = $user->nutritionTarget->target_protein;
//     $targetLemak   = $user->nutritionTarget->target_lemak;
//     $targetKarbo   = $user->nutritionTarget->target_karbo;
// }

        $from = $request->from ?? now()->subDays(7)->toDateString();
        $to   = $request->to ?? now()->toDateString();

        $data = DB::table('monitorings')
            ->join('monitoring_details','monitorings.id','=','monitoring_details.monitoring_id')
            ->where('monitorings.user_id',$user->id)
            ->whereBetween('monitorings.tanggal',[$from,$to])
            ->groupBy('monitorings.tanggal')
            ->orderBy('monitorings.tanggal')
            ->select(
                'monitorings.tanggal',
                DB::raw('SUM(monitoring_details.total_kkal) as total_kkal'),
                DB::raw('SUM(monitoring_details.total_karbo) as total_karbo'),
                DB::raw('SUM(monitoring_details.total_protein) as total_protein'),
                DB::raw('SUM(monitoring_details.total_lemak) as total_lemak')
            )
            ->get();

        $dietLogs = DietLog::where('user_id', $user->id)
            ->orderByDesc('tanggal_mulai')
            ->paginate(10);

        $todayKkal = optional(
            $data->where('tanggal', now()->toDateString())->first()
        )->total_kkal ?? 0;

        $overLimit = $todayKkal > $targetKkal;

        $latestArticle = Article::orderByDesc('tanggal')->first();

        return view('user.dashboard', compact(
            'imt','bbi','data','from','to',
            'targetKkal','targetProtein','targetLemak','targetKarbo',
            'dietLogs','todayKkal','overLimit',
            'imtKategori','imtColor',
            'latestArticle'
        ));
    }

    public function destroyLog($id)
    {
        $log = DietLog::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $log->delete();

        return back()->with('success','Log berhasil dihapus.');
    }
}
