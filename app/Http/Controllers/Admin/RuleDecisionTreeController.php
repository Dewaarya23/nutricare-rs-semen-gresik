<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RuleDecisionTree;
use Illuminate\Http\Request;

class RuleDecisionTreeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $groups = RuleDecisionTree::when($search, function ($q) use ($search) {
                $q->where('kategori_diet', 'like', "%$search%");
            })
            ->orderBy('rule_group')
            ->orderBy('urutan')
            ->get()
            ->groupBy('rule_group');

        if ($request->ajax()) {
            return view('admin.decision-tree.partials.table', compact('groups'))->render();
        }

        return view('admin.decision-tree.index', compact('groups'));
    }

    public function create()
    {
        $nextGroup = (RuleDecisionTree::max('rule_group') ?? 0) + 1;

        return view('admin.decision-tree.create', compact('nextGroup'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rule_group' => 'required|integer|min:1',
            'kategori_diet' => 'required|in:Diet Normal,Diet Diabetes Melitus,Diet Hipertensi Esensial,Diet Jantung Hipertensi',
            'conditions' => 'required|array|min:1',
            'conditions.*.parameter' => 'required|in:glukosa_darah,tekanan_darah_sistolik,kolesterol,usia',
            'conditions.*.operator' => 'required|in:<=,>',
            'conditions.*.threshold' => 'required|numeric',
        ]);

        foreach ($request->conditions as $index => $condition) {
            RuleDecisionTree::create([
                'rule_group' => $request->rule_group,
                'urutan' => $index + 1,
                'parameter' => $condition['parameter'],
                'operator' => $condition['operator'],
                'threshold' => $condition['threshold'],
                'kategori_diet' => $request->kategori_diet,
            ]);
        }

        return redirect()
            ->route('admin.decision-tree.index')
            ->with('success', 'Aturan Decision Tree berhasil ditambahkan');
    }

    public function edit($ruleGroup)
    {
        $conditions = RuleDecisionTree::where('rule_group', $ruleGroup)
            ->orderBy('urutan')
            ->get();

        if ($conditions->isEmpty()) {
            abort(404);
        }

        $conditionsForJs = $conditions->map(function ($c) {
            return [
                'parameter' => $c->parameter,
                'operator' => $c->operator,
                'threshold' => $c->threshold,
            ];
        })->values()->all();

        return view('admin.decision-tree.edit', [
            'ruleGroup' => $ruleGroup,
            'conditionsForJs' => $conditionsForJs,
            'kategoriDiet' => $conditions->first()->kategori_diet,
        ]);
    }

    public function update(Request $request, $ruleGroup)
    {
        $request->validate([
            'kategori_diet' => 'required|in:Diet Normal,Diet Diabetes Melitus,Diet Hipertensi Esensial,Diet Jantung Hipertensi',
            'conditions' => 'required|array|min:1',
            'conditions.*.parameter' => 'required|in:glukosa_darah,tekanan_darah_sistolik,kolesterol,usia',
            'conditions.*.operator' => 'required|in:<=,>',
            'conditions.*.threshold' => 'required|numeric',
        ]);

        RuleDecisionTree::where('rule_group', $ruleGroup)->delete();

        foreach ($request->conditions as $index => $condition) {
            RuleDecisionTree::create([
                'rule_group' => $ruleGroup,
                'urutan' => $index + 1,
                'parameter' => $condition['parameter'],
                'operator' => $condition['operator'],
                'threshold' => $condition['threshold'],
                'kategori_diet' => $request->kategori_diet,
            ]);
        }

        return redirect()
            ->route('admin.decision-tree.index')
            ->with('success', 'Aturan Decision Tree berhasil diperbarui');
    }

    public function destroy($ruleGroup)
    {
        RuleDecisionTree::where('rule_group', $ruleGroup)->delete();

        return redirect()
            ->route('admin.decision-tree.index')
            ->with('success', 'Aturan Decision Tree berhasil dihapus');
    }
}
