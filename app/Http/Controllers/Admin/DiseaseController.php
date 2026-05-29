<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $diseases = Disease::when($search, function ($q) use ($search) {
                $q->where('nama','like',"%$search%")
                  ->orWhere('kode_penyakit','like',"%$search%");
            })
            ->orderBy('kode_penyakit')
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.disease.partials.table', compact('diseases'))->render();
        }

        return view('admin.disease.index', compact('diseases'));
    }

    public function create()
    {
        return view('admin.disease.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
    ]);

    $lastDisease = Disease::orderBy('id', 'desc')->first();

    $nextNumber = $lastDisease
        ? intval(substr($lastDisease->kode_penyakit, 1)) + 1
        : 1;

    $kode = 'D' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    Disease::create([
        'kode_penyakit' => $kode,
        'nama' => $request->nama,
    ]);

    return redirect()
        ->route('admin.diseases.index')
        ->with('success','Penyakit berhasil ditambahkan');
}


    public function show($id)
    {
        $disease = Disease::with('menus')->findOrFail($id);
        return view('admin.disease.show', compact('disease'));
    }

    public function edit($id)
    {
        $disease = Disease::findOrFail($id);
        return view('admin.disease.edit', compact('disease'));
    }

    public function update(Request $request, $id)
    {
        $disease = Disease::findOrFail($id);

        $request->validate([
            'nama' => 'required'
        ]);

        $disease->update(['nama'=>$request->nama]);

        return redirect()->route('admin.diseases.index')
            ->with('success','Penyakit berhasil diperbarui');
    }

public function destroy($id)
{
    Disease::findOrFail($id)->delete();

    return redirect()
        ->route('admin.diseases.index')
        ->with('success','Penyakit berhasil dihapus');
}

}

