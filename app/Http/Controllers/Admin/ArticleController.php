<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderByDesc('tanggal')->get();
        return view('admin.article.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'ringkasan' => 'required',
            'isi' => 'required',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('articles','public');
        }

        Article::create($data);

        return redirect()
            ->route('admin.articles.index')
            ->with('success','Artikel berhasil diposting.');
    }

    public function edit(Article $article)
    {
        return view('admin.article.edit', compact('article'));
    }

    public function show(Article $article)
    {
        return view('admin.article.show', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'judul' => 'required',
            'ringkasan' => 'required',
            'isi' => 'required',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = $request->only([
            'judul',
            'ringkasan',
            'isi',
            'tanggal'
        ]);

        if ($request->has('hapus_gambar') && $article->gambar) {

            Storage::disk('public')->delete($article->gambar);

            $article->update([
                'gambar' => null
            ]);

            return back()->with('success','Gambar berhasil dihapus.');
        }

        if ($request->hasFile('gambar')) {

            if ($article->gambar) {
                Storage::disk('public')->delete($article->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('articles','public');
        }

        $article->update($data);

        return redirect()
            ->route('admin.articles.index')
            ->with('success','Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->gambar) {
            Storage::disk('public')->delete($article->gambar);
        }

        $article->delete();

        return back()->with('success','Artikel berhasil dihapus.');
    }
}
