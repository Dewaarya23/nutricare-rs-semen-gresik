<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Menu;
use App\Models\Disease;
use App\Models\Monitoring;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $imt = null;
        $bbi = null;

        if ($user && $user->berat_badan && $user->tinggi_badan) {

            $tbMeter = $user->tinggi_badan / 100;
            $imt = $user->berat_badan / ($tbMeter * $tbMeter);

            if ($user->jenis_kelamin === 'L') {
                $bbi = ($user->tinggi_badan - 100) * 0.9;
            } elseif ($user->jenis_kelamin === 'P') {
                $bbi = ($user->tinggi_badan - 100) * 0.85;
            }
        }

        $from = now()->subDays(6)->toDateString();
        $to   = now()->toDateString();

        $pasienList = User::where('role','user')->get();

        $selectedUserId = request()->get('user_id');

        $monitoringData = collect();

        if ($selectedUserId) {

            $monitoringData = DB::table('monitorings')
                ->join('monitoring_details','monitorings.id','=','monitoring_details.monitoring_id')
                ->where('monitorings.user_id', $selectedUserId)
                ->whereBetween('monitorings.tanggal', [$from,$to])
                ->groupBy('monitorings.tanggal')
                ->orderBy('monitorings.tanggal')
                ->select(
                    'monitorings.tanggal',
                    DB::raw('SUM(monitoring_details.total_kkal) as total_kkal')
                )
                ->get();
        }

        return view('admin.dashboard', [
            'totalPasien'   => User::where('role', 'user')->count(),
            'totalMenu'     => Menu::count(),
            'totalAdmin'    => User::where('role', 'admin')->count(),
            'totalPenyakit' => Disease::count(),
            'imt'           => $imt,
            'bbi'           => $bbi,
            'monitoringData'=> $monitoringData,
            'pasienList'    => $pasienList,
            'selectedUserId'=> $selectedUserId,
        ]);
    }
}
