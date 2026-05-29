<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Models\Menu;
use App\Models\NutritionTarget;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{

    /* =====================================================
    | LIST MONITORING USER LOGIN
    ===================================================== */
public function index(Request $request)
{
    $query = Monitoring::with(['details','user.nutritionTarget'])
        ->where('user_id', Auth::id());

    // FILTER TANGGAL
    if ($request->filled('dari') && $request->filled('sampai')) {
        $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
    }

    $monitorings = $query
        ->orderBy('tanggal', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('user.monitoring.index', compact('monitorings'));
}

    /* =====================================================
    | FORM CREATE - FIXED
    ===================================================== */
public function create()
{
    $menus = Menu::with(['weightOptions', 'diseases'])->get()->map(function ($menu) {
        return [
            'kode_menu' => $menu->kode_menu,
            'nama_menu' => $menu->nama_menu,
            'diseases'  => $menu->diseases,

            'kkal_per_gram'    => $menu->kkal_per_gram,
            'karbo_per_gram'   => $menu->karbo_per_gram,
            'protein_per_gram' => $menu->protein_per_gram,
            'lemak_per_gram'   => $menu->lemak_per_gram,

            'weight_options' => $menu->weightOptions->map(function ($w) {
                return [
                    'opsi_berat'  => $w->opsi_berat,
                    'gram'        => $w->gram,
                    'kkal_urt'    => $w->kkal_urt,    // TAMBAHKAN INI
                    'karbo_urt'   => $w->karbo_urt,   // TAMBAHKAN INI
                    'protein_urt' => $w->protein_urt, // TAMBAHKAN INI
                    'lemak_urt'   => $w->lemak_urt,   // TAMBAHKAN INI
                    'is_gram'     => strtolower(trim($w->opsi_berat)) === 'gram',
                ];
            })->values()
        ];
    })->values();

    return view('user.monitoring.create', compact('menus'));
}


    /* =====================================================
    | STORE
    ===================================================== */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'items'   => 'required|json',
        ]);

        $items = json_decode($request->items, true);

       DB::transaction(function () use ($request, $items) {

    $user = Auth::user();

    // ambil TARGET TERBARU
    $target = NutritionTarget::where('user_id', $user->id)
        ->latest('created_at')
        ->first();

    // cek apakah monitoring tanggal itu SUDAH ADA
    $monitoring = Monitoring::where('user_id', $user->id)
        ->where('tanggal', $request->tanggal)
        ->first();

    if (!$monitoring) {
        // JIKA BELUM ADA → BUAT BARU
        $monitoring = Monitoring::create([
            'user_id'        => $user->id,
            'tanggal'        => $request->tanggal,
            'target_kkal'    => optional($target)->target_kkal,
            'target_karbo'   => optional($target)->target_karbo,
            'target_protein' => optional($target)->target_protein,
            'target_lemak'   => optional($target)->target_lemak,
        ]);
    } else {
        // JIKA SUDAH ADA → UPDATE TARGET KE YANG TERBARU
        $monitoring->update([
            'target_kkal'    => optional($target)->target_kkal,
            'target_karbo'   => optional($target)->target_karbo,
            'target_protein' => optional($target)->target_protein,
            'target_lemak'   => optional($target)->target_lemak,
        ]);

        // hapus detail lama
        $monitoring->details()->delete();
    }

    foreach ($items as $jenis => $rows) {
        if (count($rows) === 0) continue;

        $detail = $monitoring->details()->create([
            'jenis_makan'   => $jenis,
            'total_kkal'    => collect($rows)->sum('kkal'),
            'total_karbo'   => collect($rows)->sum('karbo'),
            'total_protein' => collect($rows)->sum('protein'),
            'total_lemak'   => collect($rows)->sum('lemak'),
        ]);

        foreach ($rows as $r) {
            $detail->items()->create([
                'kode_menu'  => $r['kode_menu'],
                'opsi_berat' => $r['opsi_berat'],
                'qty'        => $r['qty'],
                'gram'       => $r['gram'],
                'kkal'       => $r['kkal'],
                'karbo'      => $r['karbo'],
                'protein'    => $r['protein'],
                'lemak'      => $r['lemak'],
            ]);
        }
    }
});

        return redirect()
            ->route('user.monitoring.index')
            ->with('success', 'Monitoring berhasil disimpan');
    }

    /* =====================================================
| SHOW
===================================================== */
public function show(Monitoring $monitoring)
{
    if ($monitoring->user_id !== Auth::id()) {
        abort(403);
    }

    $monitoring->load('details.items');

    return view('user.monitoring.show', compact('monitoring'));
}


/* =====================================================
| EDIT
===================================================== */
public function edit(Monitoring $monitoring)
{
    if ($monitoring->user_id !== Auth::id()) {
        abort(403);
    }

    $menus = Menu::with(['weightOptions', 'diseases'])
        ->get()
        ->map(function ($menu) {
            return [
                'kode_menu' => $menu->kode_menu,
                'nama_menu' => $menu->nama_menu,
                'diseases'  => $menu->diseases,

                'kkal_per_gram'    => $menu->kkal_per_gram,
                'karbo_per_gram'   => $menu->karbo_per_gram,
                'protein_per_gram' => $menu->protein_per_gram,
                'lemak_per_gram'   => $menu->lemak_per_gram,

                'weight_options' => $menu->weightOptions->map(function ($w) {
                    return [
                        'opsi_berat'  => $w->opsi_berat,
                        'gram'        => $w->gram,
                        'kkal_urt'    => $w->kkal_urt,
                        'karbo_urt'   => $w->karbo_urt,
                        'protein_urt' => $w->protein_urt,
                        'lemak_urt'   => $w->lemak_urt,
                        'is_gram'     => strtolower(trim($w->opsi_berat)) === 'gram',
                    ];
                })->values()
            ];
        })->values();

    $monitoring->load('details.items');

    return view('user.monitoring.edit', compact('monitoring', 'menus'));
}

/* =====================================================
| UPDATE
===================================================== */
public function update(Request $request, Monitoring $monitoring)
{
    if ($monitoring->user_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'tanggal' => 'required|date',
        'items'   => 'required|json',
    ]);

    $items = json_decode($request->items, true);

    DB::transaction(function () use ($request, $items, $monitoring) {

        $monitoring->update([
            'tanggal' => $request->tanggal,
        ]);

        $monitoring->details()->delete();

        foreach ($items as $jenis => $rows) {

            if (count($rows) === 0) continue;

            $detail = $monitoring->details()->create([
                'jenis_makan'   => $jenis,
                'total_kkal'    => collect($rows)->sum('kkal'),
                'total_karbo'   => collect($rows)->sum('karbo'),
                'total_protein' => collect($rows)->sum('protein'),
                'total_lemak'   => collect($rows)->sum('lemak'),
            ]);

            foreach ($rows as $r) {
                $detail->items()->create($r);
            }
        }
    });

    return redirect()
        ->route('user.monitoring.index')
        ->with('success', 'Monitoring berhasil diupdate');
}


/* =====================================================
| DELETE
===================================================== */
public function destroy(Monitoring $monitoring)
{
    if ($monitoring->user_id !== Auth::id()) {
        abort(403);
    }

    $monitoring->delete();

    return redirect()
        ->route('user.monitoring.index')
        ->with('success', 'Monitoring berhasil dihapus');
}

// EXPORT PDF USER
public function exportPdf(Request $request)
{
    $query = Monitoring::with('details')
        ->where('user_id', Auth::id());

    if ($request->filled('dari') && $request->filled('sampai')) {
        $query->whereBetween('tanggal', [
            $request->dari,
            $request->sampai
        ]);
    }

    $monitorings = $query
        ->orderBy('tanggal','desc')
        ->get();

    $pdf = Pdf::loadView(
        'user.monitoring.export-pdf',
        compact('monitorings')
    )->setPaper('A4','landscape');

    return $pdf->download('Monitoring-Gizi-Saya.pdf');
}

}
