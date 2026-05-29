<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\User;
use App\Models\Monitoring;
use App\Models\MonitoringDetail;
use App\Models\MonitoringItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MonitoringController extends Controller
{
    /* =====================================================
    | LIST PASIEN + REKAP MONITORING
    ===================================================== */
public function index(Request $request)
{
    $monitorings = Monitoring::with(['user.nutritionTarget','details'])
        ->when($request->filled('nama'), function ($q) use ($request) {
            $q->whereHas('user', function ($u) use ($request) {
                $u->where('nama', 'like', '%' . $request->nama . '%');
            });
        })
        ->when(
            $request->filled('tanggal_mulai') &&
            $request->filled('tanggal_sampai'),
            function ($q) use ($request) {
                $q->whereBetween('tanggal', [
                    $request->tanggal_mulai,
                    $request->tanggal_sampai
                ]);
            }
        )
        ->orderBy('tanggal','desc')
        ->paginate(10)
        ->withQueryString();

        $menus = Menu::with('weightOptions')->get()->map(function ($menu) {
    return [
        'kode_menu' => $menu->kode_menu,
        'nama_menu' => $menu->nama_menu,
        'diseases'  => $menu->diseases,

        // PER GRAM
        'kkal_per_gram' => $menu->kkal_per_gram,
        'karbo_per_gram' => $menu->karbo_per_gram,
        'protein_per_gram' => $menu->protein_per_gram,
        'lemak_per_gram' => $menu->lemak_per_gram,

        // 🔥 PER URT (FIX UTAMA)
        'kkal_per_urt' => $menu->kkal_urt,
        'karbo_per_urt' => $menu->karbo_per_gram * $menu->gram_urt_standart,
        'protein_per_urt' => $menu->protein_per_gram * $menu->gram_urt_standart,
        'lemak_per_urt' => $menu->lemak_per_gram * $menu->gram_urt_standart,

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
})
    ];
});

    $patients = User::where('role', 'user')
        ->whereNotNull('nama')
        ->get();

    return view('admin.monitoring.list', compact(
        'monitorings',
        'menus',
        'patients'
    ));
}

    /* =====================================================
| LIVE SEARCH (AJAX)
===================================================== */
public function search(Request $request)
{
    $query = Monitoring::with(['user.nutritionTarget','details']);

    if ($request->filled('nama')) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('nama','like','%'.$request->nama.'%');
        });
    }

    if ($request->filled('tanggal_mulai')) {
        $query->where('tanggal','>=',$request->tanggal_mulai);
    }

    if ($request->filled('tanggal_sampai')) {
        $query->where('tanggal','<=',$request->tanggal_sampai);
    }

    $monitorings = $query->orderBy('tanggal','desc')->get();

    // KUNCI: return partial _table.blade.php
    return view('admin.monitoring.partials._table', compact('monitorings'));
}


/* =====================================================
| LIVE SEARCH PASIEN (AJAX)
===================================================== */
public function searchPatient(Request $request)
{
    $keyword = $request->keyword;

    $patients = User::with('diseases')
        ->where('role', 'user')
        ->whereNotNull('nama')
        ->where('nama', 'like', '%' . $keyword . '%')
        ->limit(10)
        ->get();

    return response()->json($patients);
}


    /* =====================================================
    | FORM ENTRY MONITORING
    ===================================================== */
    public function create()
    {
       $menus = Menu::with(['weightOptions','diseases'])->get()->map(function ($menu) {
    return [
        'kode_menu' => $menu->kode_menu,
        'nama_menu' => $menu->nama_menu,
        'diseases'  => $menu->diseases,

        'kkal_per_gram' => $menu->kkal_per_gram,
        'karbo_per_gram' => $menu->karbo_per_gram,
        'protein_per_gram' => $menu->protein_per_gram,
        'lemak_per_gram' => $menu->lemak_per_gram,

        'kkal_per_urt' => $menu->kkal_urt,
        'karbo_per_urt' => $menu->karbo_per_gram * $menu->gram_urt_standart,
        'protein_per_urt' => $menu->protein_per_gram * $menu->gram_urt_standart,
        'lemak_per_urt' => $menu->lemak_per_gram * $menu->gram_urt_standart,

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
})
    ];
});
        $patients = User::where('role', 'user')
        ->whereNotNull('nama')
        ->get();

        // ⬇️ HARUS create, BUKAN index
        return view('admin.monitoring.create', compact('menus','patients'));
    }

    /* =====================================================
    | SIMPAN DATA MONITORING
    ===================================================== */
    public function store(Request $request)
    {
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'tanggal' => 'required|date',
        'items'   => 'required|json',
    ]);

    $items = json_decode($request->items, true);

    DB::transaction(function () use ($request, $items) {

        $user   = User::find($request->user_id);
        $target = $user->nutritionTarget;

        $monitoring = Monitoring::firstOrCreate(
            [
                'user_id' => $request->user_id,
                'tanggal' => $request->tanggal,
            ],
            [
                'target_kkal'    => optional($target)->target_kkal,
                'target_karbo'   => optional($target)->target_karbo,
                'target_protein' => optional($target)->target_protein,
                'target_lemak'   => optional($target)->target_lemak,
            ]
        );

        foreach ($items as $jenis => $rows) {

            if (count($rows) === 0) continue;

            $detail = MonitoringDetail::where('monitoring_id', $monitoring->id)
                ->where('jenis_makan', $jenis)
                ->first();

            if ($detail) {
                $detail->items()->delete();
                $detail->delete();
            }

            $detail = MonitoringDetail::create([
                'monitoring_id'  => $monitoring->id,
                'jenis_makan'    => $jenis,
                'total_kkal'     => 0,
                'total_karbo'    => 0,
                'total_protein'  => 0,
                'total_lemak'    => 0,
            ]);

            // 🔥 TOTAL BARU
            $total_kkal = 0;
            $total_karbo = 0;
            $total_protein = 0;
            $total_lemak = 0;

           foreach ($rows as $r) {

    $menu = Menu::with('weightOptions')
        ->where('kode_menu', $r['kode_menu'])
        ->first();

    if (!$menu) continue;

    $opsi = strtolower(trim($r['opsi_berat'] ?? ''));

$weightOptions = $menu->weightOptions;

$weight = $weightOptions->filter(function ($item) use ($opsi) {
    return strtolower(trim($item->opsi_berat)) === $opsi;
})->first();

    if (!$weight) continue;

    $qty = $r['qty'];
    $gram_per_unit = $weight->gram;

    // 🔥 TOTAL GRAM (INI KUNCI)
    $total_gram = $qty * $gram_per_unit;

    // 🔥 HITUNG DARI MENU (SUMBER UTAMA)
    $kkal    = $total_gram * $menu->kkal_per_gram;
    $karbo   = $total_gram * $menu->karbo_per_gram;
    $protein = $total_gram * $menu->protein_per_gram;
    $lemak   = $total_gram * $menu->lemak_per_gram;

    // 🔥 AKUMULASI
    $total_kkal += $kkal;
    $total_karbo += $karbo;
    $total_protein += $protein;
    $total_lemak += $lemak;

    MonitoringItem::create([
        'monitoring_detail_id' => $detail->id,
        'kode_menu'  => $r['kode_menu'],
        'opsi_berat' => $r['opsi_berat'],
        'qty'        => $qty,
        'gram'       => $total_gram,
        'kkal'       => $kkal,
        'karbo'      => $karbo,
        'protein'    => $protein,
        'lemak'      => $lemak,
    ]);
}

            // 🔥 UPDATE TOTAL
            $detail->update([
                'total_kkal'    => $total_kkal,
                'total_karbo'   => $total_karbo,
                'total_protein' => $total_protein,
                'total_lemak'   => $total_lemak,
            ]);
        }

    //HITUNG TOTAL SEMUA DETAIL (PENTING)
    $totalMonitoring = MonitoringDetail::where('monitoring_id', $monitoring->id)
        ->sum('total_kkal');

    //SIMPAN KE MONITORINGS
    Monitoring::where('id', $monitoring->id)
    ->update([
        'total_kkal' => $totalMonitoring
    ]);

    });

    return redirect()
        ->route('admin.monitoring.index')
        ->with('success','Data makan berhasil disimpan');
}

        /* =====================================================
    | SIMPAN/UPDATE PER MAKAN
    ===================================================== */
public function savePerMakan(Request $request, Monitoring $monitoring, $jenis)
{
    $items = json_decode($request->items, true);

    if (!isset($items[$jenis])) {
        return back()->with('error','Data tidak ditemukan');
    }

    DB::transaction(function () use ($monitoring, $jenis, $items) {

        $detail = MonitoringDetail::firstOrCreate([
            'monitoring_id' => $monitoring->id,
            'jenis_makan'   => $jenis,
        ]);

        // hapus item lama HANYA jenis ini
        $detail->items()->delete();

        $total_kkal    = collect($items[$jenis])->sum('kkal');
        $total_karbo   = collect($items[$jenis])->sum('karbo');
        $total_protein = collect($items[$jenis])->sum('protein');
        $total_lemak   = collect($items[$jenis])->sum('lemak');

        $detail->update([
            'total_kkal'    => $total_kkal,
            'total_karbo'   => $total_karbo,
            'total_protein' => $total_protein,
            'total_lemak'   => $total_lemak,
        ]);

        foreach ($items[$jenis] as $r) {
            MonitoringItem::create([
                'monitoring_detail_id' => $detail->id,
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

        //HITUNG ULANG TOTAL SEMUA MAKAN
        $totalMonitoring = MonitoringDetail::where('monitoring_id', $monitoring->id)
            ->sum('total_kkal');

        //UPDATE KE MONITORINGS
        $monitoring->update([
            'total_kkal' => $totalMonitoring
        ]);
    });

    return back()->with('success','Data '.$jenis.' berhasil disimpan');
}


        /* =====================================================
    | DELETE PER MAKAN
    ===================================================== */
    public function deletePerMakan(MonitoringDetail $detail)
{
    $detail->delete();

    return back()->with('success','Data makan berhasil dihapus');
}


    /* =====================================================
    | EDIT DATA (1 HARI)
    ===================================================== */
    public function edit(Monitoring $monitoring)
    {
        $monitoring->load([
            'user',
            'details.items'
        ]);

        $menus = Menu::with(['weightOptions','diseases'])->get()->map(function ($menu) {
    return [
        'kode_menu' => $menu->kode_menu,
        'nama_menu' => $menu->nama_menu,
        'diseases'  => $menu->diseases,

        'kkal_per_gram' => $menu->kkal_per_gram,
        'karbo_per_gram' => $menu->karbo_per_gram,
        'protein_per_gram' => $menu->protein_per_gram,
        'lemak_per_gram' => $menu->lemak_per_gram,

        'kkal_per_urt' => $menu->kkal_urt,
        'karbo_per_urt' => $menu->karbo_per_gram * $menu->gram_urt_standart,
        'protein_per_urt' => $menu->protein_per_gram * $menu->gram_urt_standart,
        'lemak_per_urt' => $menu->lemak_per_gram * $menu->gram_urt_standart,

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
})
    ];
});
        $patients = User::where('role','user')->get();

        return view('admin.monitoring.edit', compact(
            'monitoring',
            'menus',
            'patients'
        ));
    }

    /* =====================================================
    | UPDATE DATA
    ===================================================== */
    public function update(Request $request, Monitoring $monitoring)
{
    $items = json_decode($request->items, true);

    DB::transaction(function () use ($request, $monitoring, $items) {

        $monitoring->update([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal
        ]);

        foreach ($monitoring->details as $d) {
            $d->items()->delete();
            $d->delete();
        }

        foreach ($items as $jenis => $rows) {

            if (count($rows) === 0) continue;

            $detail = MonitoringDetail::firstOrCreate([
                'monitoring_id' => $monitoring->id,
                'jenis_makan'   => $jenis,
            ]);

            $detail->items()->delete();

            // 🔥 TOTAL BARU
            $total_kkal = 0;
            $total_karbo = 0;
            $total_protein = 0;
            $total_lemak = 0;

           foreach ($rows as $r) {

    $menu = Menu::with('weightOptions')
        ->where('kode_menu', $r['kode_menu'])
        ->first();

    if (!$menu) continue;

    $opsi = strtolower(trim($r['opsi_berat'] ?? ''));

$weightOptions = $menu->weightOptions;

$weight = $weightOptions->filter(function ($item) use ($opsi) {
    return strtolower(trim($item->opsi_berat)) === $opsi;
})->first();

    if (!$weight) continue;

    $qty = $r['qty'];
    $gram_per_unit = $weight->gram;

    $total_gram = $qty * $gram_per_unit;

    $kkal    = $total_gram * $menu->kkal_per_gram;
    $karbo   = $total_gram * $menu->karbo_per_gram;
    $protein = $total_gram * $menu->protein_per_gram;
    $lemak   = $total_gram * $menu->lemak_per_gram;

    $total_kkal += $kkal;
    $total_karbo += $karbo;
    $total_protein += $protein;
    $total_lemak += $lemak;

    MonitoringItem::create([
        'monitoring_detail_id' => $detail->id,
        'kode_menu'  => $r['kode_menu'],
        'opsi_berat' => $r['opsi_berat'],
        'qty'        => $qty,
        'gram'       => $total_gram,
        'kkal'       => $kkal,
        'karbo'      => $karbo,
        'protein'    => $protein,
        'lemak'      => $lemak,
    ]);
}

            // 🔥 UPDATE TOTAL
            $detail->update([
                'total_kkal'    => $total_kkal,
                'total_karbo'   => $total_karbo,
                'total_protein' => $total_protein,
                'total_lemak'   => $total_lemak,
            ]);
        }

        //HITUNG TOTAL BARU SETELAH UPDATE
        $totalMonitoring = MonitoringDetail::where('monitoring_id', $monitoring->id)
            ->sum('total_kkal');

        //UPDATE KE MONITORING
        $monitoring->update([
            'total_kkal' => $totalMonitoring
        ]);
    });

    return redirect()
        ->route('admin.monitoring.index')
        ->with('success','Monitoring berhasil diupdate');
}

    /* =====================================================
    | DETAIL MONITORING (VIEW)
    ===================================================== */
    public function show(Monitoring $monitoring)
    {
        $monitoring->load([
            'user',
            'details.items.menu'
        ]);

        return view('admin.monitoring.show', compact('monitoring'));
    }


    /* =====================================================
    | EDIT DETAIL (PER PAGI / SIANG / MALAM)  ✅ BARU
    ===================================================== */
    public function editDetail(MonitoringDetail $detail)
    {
        $detail->load([
            'monitoring.user',
            'items'
        ]);

        $menus = Menu::with('weightOptions')->get();

        return view('admin.monitoring.edit-detail', compact(
            'detail',
            'menus'
        ));
    }

    /* =====================================================
    | DESTROY
    ===================================================== */
    public function destroyItem(MonitoringItem $item)
    {
        $item->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroyDetail(MonitoringDetail $detail)
    {
        $detail->items()->delete();
        $detail->delete();

        return back()->with('success','Data makan dihapus');
    }

    public function destroy(Monitoring $monitoring)
    {
    foreach ($monitoring->details as $d) {
        $d->items()->delete();
        $d->delete();
    }

    $monitoring->delete();

    return redirect()
        ->route('admin.monitoring.index')
        ->with('success','Data monitoring dihapus');
    }

    //EXPORT PDF
    public function exportPdf(Request $request)
{
    $query = Monitoring::with(['user','details']);

    if ($request->filled('nama')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('nama','like','%'.$request->nama.'%');
        });
    }

    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_sampai')) {
        $query->whereBetween('tanggal', [
            $request->tanggal_mulai,
            $request->tanggal_sampai
        ]);
    }

    $monitorings = $query->orderBy('tanggal','desc')->get();

        $pdf = Pdf::loadView('admin.monitoring.export-pdf', compact('monitorings'))
        ->setPaper('A4','landscape')
        ->setOption('isRemoteEnabled', true);

return $pdf->download('Monitoring-Gizi.pdf');
}

}
