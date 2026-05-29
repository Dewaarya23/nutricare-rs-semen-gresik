<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
public function index(Request $request)
{
    // AMBIL SEMUA USER (KECUALI ADMIN)
    $patients = User::where('role', 'user')
        ->orderBy('nama')
        ->paginate(10);

    // JIKA ADA SEARCH
    if ($request->search) {
        $patients = User::where('role', 'user')
            ->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->orderBy('nama')
            ->paginate(10);
    }

    // JIKA PILIH TIPE USER (PAS KLIK DROPDOWN)
    if ($request->keterangan_user == 'pasien' || $request->keterangan_user == 'pegawai') {
        $patients = User::where('role', 'user')
            ->where('tipe_user', $request->keterangan_user)
            ->orderBy('nama')
            ->paginate(10);
    }

    if ($request->ajax()) {
        return view('admin.patient.partials.table', compact('patients'));
    }

    return view('admin.patient.index', compact('patients'));
}


    /* ==========================================================
    | FORM TAMBAH PASIEN
    ========================================================== */
    public function create()
    {
        $diseases = Disease::all();
        return view('admin.patient.create', compact('diseases'));
    }


    /* ==========================================================
    | SIMPAN PASIEN BARU
    ========================================================== */
    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required',
            'email'           => 'required|email|unique:users',
            'password'        => 'required|min:6',
            'tanggal_lahir'   => 'required',
            'no_telp'         => 'required',
            'jenis_kelamin'   => 'required',
            'berat_badan'     => 'required|numeric',
            'tinggi_badan'    => 'required|numeric',
            'ada_riwayat'     => 'required',
        ]);

        User::create([
            'nama'              => $request->nama,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'tanggal_lahir'     => $request->tanggal_lahir,
            'no_telp'           => $request->no_telp,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'berat_badan'       => $request->berat_badan,
            'tinggi_badan'      => $request->tinggi_badan,
            'ada_riwayat'       => $request->ada_riwayat,
            'riwayat_penyakit'  => $request->ada_riwayat == 'ya'
                                    ? implode(',', $request->riwayat_penyakit ?? [])
                                    : null,
            'role'              => 'user'
        ]);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Pasien berhasil ditambahkan');
    }


    /* ==========================================================
    | FORM EDIT PASIEN
    ========================================================== */
    public function edit($id)
    {
        $patient  = User::findOrFail($id);
        $diseases = Disease::all();

        return view('admin.patient.edit', compact('patient', 'diseases'));
    }


    /* ==========================================================
    | UPDATE PASIEN
    ========================================================== */
    public function update(Request $request, $id)
    {
        $patient = User::findOrFail($id);

        $request->validate([
            'nama'           => 'required',
            'tanggal_lahir'  => 'required',
            'no_telp'        => 'required',
            'jenis_kelamin'  => 'required',
            'berat_badan'    => 'required|numeric',
            'tinggi_badan'   => 'required|numeric',
            'password'       => 'nullable|min:6',
        ]);

        $data = [
            'nama'             => $request->nama,
            'tanggal_lahir'    => $request->tanggal_lahir,
            'no_telp'          => $request->no_telp,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'berat_badan'      => $request->berat_badan,
            'tinggi_badan'     => $request->tinggi_badan,
            'tipe_user'        => $request->tipe_user,
            'ada_riwayat'      => $request->filled('diseases') ? 'ya' : 'tidak',
            'riwayat_penyakit' => $request->filled('diseases')
                                    ? implode(',', $request->diseases)
                                    : null
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $patient->update($data);
        $patient->diseases()->sync($request->diseases ?? []);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Data pasien berhasil diperbarui');
    }


    public function show($id)
    {
        $patient = User::with('diseases')->findOrFail($id);

        $from = now()->subDays(7)->toDateString();
        $to   = now()->toDateString();

        $data = DB::table('monitorings')
            ->join('monitoring_details', 'monitorings.id', '=', 'monitoring_details.monitoring_id')
            ->where('monitorings.user_id', $patient->id)
            ->whereBetween('monitorings.tanggal', [$from, $to])
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

        return view('admin.patient.show', compact('patient', 'data'));
    }


    /* ==========================================================
    | HAPUS PASIEN
    ========================================================== */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Data pasien berhasil dihapus');
    }
}
