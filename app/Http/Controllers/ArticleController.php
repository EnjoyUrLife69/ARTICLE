<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Categorie::all();

        $articles = Article::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categorie_id' => 'required',
        ]);

        $article = new Article();
        $article->title = $request->input('title');
        $article->release_date = Carbon::today();
        $article->description = $request->input('description');
        $article->content = $request->input('content');
        $article->categorie_id = $request->input('categorie_id');
        $article->user_id = auth()->user()->id;
        $article->status = $request->input('status') ?? 'pending';

        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Simpan gambar ke storage/app/public/images/articles
            $path = $image->storeAs('images/articles', $imageName);

            // Menyimpan nama file ke database
            $article->cover = $imageName;
        }

        $article->save();
        return redirect()->route('articles.index')->with('success', 'Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $articles = Article::FindOrFail($id);
        $existingCover = $articles->cover;

        $categories = Categorie::all();

        return view('articles.edit', compact('articles', 'categories', 'existingCover'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categorie_id' => 'required',
            'description' => 'required',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->input('title');
        $article->release_date = Carbon::today();
        $article->description = $request->input('description');
        $article->content = $request->input('content');
        $article->categorie_id = $request->input('categorie_id');
        $article->user_id = auth()->user()->id;
        $article->status = $request->input('status') ?? 'pending';

        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Simpan gambar baru ke storage
            $path = $image->storeAs('images/articles', $imageName);

            // Hapus gambar lama jika ada
            if ($article->cover) {
                Storage::delete('images/articles/' . $article->cover);
            }

            // Simpan nama file baru ke database
            $article->cover = $imageName;
        }

        $article->save();
        return redirect()->route('articles.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $articles = Article::findOrFail($id);
        $articles->delete();

        return redirect()->route('articles.index')->with('success', 'Data deleted successfully.');
    }
}
