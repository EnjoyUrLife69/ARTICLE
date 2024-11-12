<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class ArticleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:article-list|article-create|article-edit|article-delete', ['only' => ['index','show']]);
         $this->middleware('permission:article-create', ['only' => ['create','store']]);
         $this->middleware('permission:article-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:article-delete', ['only' => ['destroy']]);
         $this->middleware('permission:accept-request', ['only' => ['request', 'approve', 'reject']]);
    }

    public function sidebarData()
    {
        // Menghitung artikel baru dengan status 'pending' ( Notification)
        $newArticlesCount = Article::where('status', 'pending')
            ->whereDate('created_at', '>=', now()->subDay())
            ->count();

        return view('backend.sidebar', compact('newArticlesCount'));
    }

    public function approve($id)
    {
        $articles = Article::findOrFail($id);
        $articles->status = 'approved'; // Status bisa disesuaikan, misalnya 'approved'
        $articles->save();

        return redirect()->route('request')->with('success', 'The article has been Approved');
    }

    public function reject($id)
    {
        $articles = Article::findOrFail($id);
        $articles->status = 'rejected'; // Status bisa disesuaikan, misalnya 'rejected'
        $articles->save();

        return redirect()->route('request')->with('success', 'The article has been Rejected');

    }

    public function request()
    {
        $categories = Categorie::all();
        $articles = Article::where('status', 'pending')->get(); // Hanya artikel yang statusnya 'pending'

        return view('articles.request', compact('articles', 'categories'));
    }

    public function index()
    {
        $categories = Categorie::all();
        $articles = Article::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $approvedArticlesCount = Article::where('status', 'approved')->count();

        return view('articles.index', compact('articles', 'categories' , 'approvedArticlesCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::limit(5)->get();

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

        $categories = Categorie::limit(5)->get();


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
