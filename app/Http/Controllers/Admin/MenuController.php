<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Disease;
use App\Models\MenuWeightOption;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori ?? 'ALL';
        $search   = $request->search;

        $menus = Menu::query()
            ->when($kategori !== 'ALL', fn($q) => $q->where('kategori',$kategori))
            ->when($search, fn($q) =>
                $q->where('nama_menu','LIKE',"%{$search}%")
            )
            ->orderByRaw("
                CASE
                    WHEN kode_menu LIKE 'STIL%' THEN 1
                    WHEN kode_menu LIKE 'STL%'  THEN 2
                    WHEN kode_menu LIKE 'SRL%'  THEN 3
                    WHEN kode_menu LIKE 'BG%'   THEN 4
                    WHEN kode_menu LIKE 'S%'    THEN 5
                    WHEN kode_menu LIKE 'K%'    THEN 6
                    WHEN kode_menu LIKE 'PHR%'  THEN 7
                    WHEN kode_menu LIKE 'PHS%'  THEN 8
                    WHEN kode_menu LIKE 'PST%'  THEN 9
                    WHEN kode_menu LIKE 'PN%'   THEN 10
                    WHEN kode_menu LIKE 'M%'    THEN 11
                    ELSE 99
                END
            ")
            ->orderByRaw("CAST(REGEXP_SUBSTR(kode_menu,'[0-9]+') AS UNSIGNED)")
            ->paginate(50)
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.menu.partials.table', compact('menus'))->render();
        }

        return view('admin.menu.index', compact('menus','kategori','search'));
    }

    public function create()
    {
        return view('admin.menu.create', [
            'diseases' => Disease::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori'         => 'required',
            'kode_menu'        => 'required|unique:menus',
            'nama_menu'        => 'required',
            'kkal_per_gram'    => 'required|numeric|min:0',
            'karbo_per_gram'   => 'required|numeric|min:0',
            'protein_per_gram' => 'required|numeric|min:0',
            'lemak_per_gram'   => 'required|numeric|min:0',
            'takaran'          => 'required|array|min:1|max:2',
        ]);

        if (!in_array('GRAM', $request->takaran)) {
            return back()->withErrors('Takaran wajib memiliki GRAM');
        }

        $menu = Menu::create($request->only([
            'kode_menu','kategori','nama_menu',
            'kkal_per_gram','karbo_per_gram',
            'protein_per_gram','lemak_per_gram'
        ]));

        foreach ($request->takaran as $t) {
        $t = strtoupper(trim($t));

    $defaultGram = match($t) {
        'GRAM' => 1,
        'GELAS' => 200,
        'SDM' => 15,
        'SDT' => 5,
        'BUAH' => 100,
        'BUAH BESAR' => 150,
        'BUAH SEDANG' => 100,
        'BUAH KECIL' => 50,
        'POTONG SEDANG' => 50,
        'POTONG BESAR' => 100,
        'POTONG KECIL' => 25,
        'IRIS' => 10,
        'BUTIR' => 50,
        'BUTIR KECIL' => 30,
        'BIJI' => 50,
        'BIJI SEDANG' => 60,
        'BULATAN' => 100,
        'EKOR' => 80,
        default => 1
    };

    MenuWeightOption::create([
        'kode_menu' => $menu->kode_menu,
        'opsi_berat'=> $t,
        'gram'      => $defaultGram
    ]);
}

        $menu->diseases()->sync($request->diseases ?? []);

        return redirect()->route('admin.menu.index')
            ->with('success','Menu berhasil ditambahkan');
    }

    public function edit($kode_menu)
    {
        $menu = Menu::with(['weightOptions','diseases'])
            ->where('kode_menu',$kode_menu)
            ->firstOrFail();

        return view('admin.menu.edit', [
            'menu'=>$menu,
            'diseases'=>Disease::all()
        ]);
    }

    public function update(Request $request, $kode_menu)
    {
        $menu = Menu::where('kode_menu',$kode_menu)->firstOrFail();

        $menu->update($request->only([
            'nama_menu','kkal_per_gram',
            'karbo_per_gram','protein_per_gram','lemak_per_gram'
        ]));

        foreach ($request->takaran as $id => $data) {

    if (!isset($data['gram']) || $data['gram'] <= 0) {
        return back()
            ->withErrors('Nilai gram tidak boleh kosong atau 0')
            ->withInput();
    }

    if ($data['gram'] > 1000) {
        return back()
            ->withErrors('Nilai gram terlalu besar (tidak realistis)')
            ->withInput();
    }

    MenuWeightOption::where('id',$id)->update([
        'gram' => $data['gram']
    ]);
}

        $menu->diseases()->sync($request->diseases ?? []);

        return redirect()->route('admin.menu.index')
            ->with('success','Menu berhasil diperbarui');
    }

    public function destroy($kode_menu)
    {
        Menu::where('kode_menu',$kode_menu)->delete();

        return back()->with('success','Menu dihapus');
    }

    public function show($kode_menu)
    {
        $menu = Menu::with('diseases','weightOptions')
            ->where('kode_menu',$kode_menu)
            ->firstOrFail();

        return view('admin.menu.show', compact('menu'));
    }

    public function generateCode($kategori)
    {
        $last = Menu::where('kode_menu','LIKE',$kategori.'%')
            ->orderByRaw("CAST(REGEXP_SUBSTR(kode_menu,'[0-9]+') AS UNSIGNED) DESC")
            ->first();

        $number = $last
            ? intval(preg_replace('/\D/','',$last->kode_menu)) + 1
            : 1;

        return response()->json([
            'kode' => $kategori . str_pad($number,3,'0',STR_PAD_LEFT)
        ]);
    }
}
