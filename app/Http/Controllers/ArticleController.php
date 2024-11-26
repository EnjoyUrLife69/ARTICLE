<?php

namespace App\Http\Controllers;

use App\Models\Activitie;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:article-list|article-create|article-edit|article-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:article-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:article-edit', ['only' => ['edit', 'update']]);
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
        $article = Article::findOrFail($id);
        $article->status = 'approved';
        $article->save();

        // Kirim notifikasi ke penulis
        Notification::create([
            'user_id' => $article->user_id,
            'title' => 'Article Approved',
            'message' => "Your Article titled '{$article->title}' has been Approved.",
        ]);

        return redirect()->route('request')->with('success', 'The article has been Approved');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'review_notes' => 'required|string', // Validasi review notes
        ]);

        $article = Article::findOrFail($id);
        $article->status = 'rejected';
        $article->save();

        Notification::create([
            'user_id' => $article->user_id,
            'title' => 'Article Rejected',
            'message' => "Your Article titled '{$article->title}' has been Rejected.",
            'review_notes' => $request->input('review_notes'),
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('request')->with('success', 'Article rejected with feedback.');
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

        return view('articles.index', compact('articles', 'categories', 'approvedArticlesCount'));
    }

    public function allArticles()
    {
        $categories = Categorie::all();

        // Mengambil semua artikel tanpa memfilter berdasarkan user
        $articles = Article::orderBy('created_at', 'desc')->get();

        $approvedArticlesCount = Article::where('status', 'approved')->count();

        return view('articles.all', compact('articles', 'categories', 'approvedArticlesCount'));
    }

    public function create()
    {
        $categories = Categorie::orderBy('name', 'asc')->get();

        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'categorie_id' => 'required',
            'description' => 'required',
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

        Activitie::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'article_id' => $article->id,
            'details' => "Created an article with the title <b>'{$article->title}'</b>",
            'img' => $article->cover,
            'description' => $article->description,
            'categorie_name' => $article->categorie ? $article->categorie->name : 'No category',
        ]);

        $article->save();
        return redirect()->route('articles.index')->with('success', 'Data created successfully.');
    }

    public function show(Article $article)
    {
        //
    }

    public function edit($id)
    {
        $articles = Article::FindOrFail($id);

        $existingCover = $articles->cover;

        $categories = Categorie::orderBy('name', 'asc')->get();

        return view('articles.edit', compact('articles', 'categories', 'existingCover'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3048',
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

        // Cek status artikel
        if ($article->status === 'approved') {
            $article->status = 'approved';
        } elseif ($article->status === 'rejected') {
            $article->status = 'pending';
        } else {
            $article->status = $request->input('status') ?? 'pending';
        }

        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Simpan gambar baru ke storage
            $path = $image->storeAs('images/articles', $imageName);

            // Periksa apakah cover lama digunakan di aktivitas lain
            if ($article->cover && !Activitie::where('img', $article->cover)->exists()) {
                Storage::delete('images/articles/' . $article->cover);
            }

            // Simpan nama file baru ke database
            $article->cover = $imageName;
        }

        Activitie::create([
            'user_id' => auth()->id(),
            'action' => 'edit',
            'article_id' => $article->id,
            'details' => "Edited an article with the title <b>'{$article->title}'</b>",
            'img' => $article->cover,
            'description' => $article->description,
            'categorie_name' => $article->categorie ? $article->categorie->name : 'No category',
        ]);

        $article->save();
        return redirect()->route('articles.index')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $articles = Article::findOrFail($id);
        Activitie::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'article_id' => $articles->id,
            'details' => "Deleted an article with the title <b>'{$articles->title}'</b>",
            'img' => $articles->cover,
            'description' => $articles->description,
            'categorie_name' => $articles->categorie ? $articles->categorie->name : 'No category',
        ]);

        $articles->delete();

        return redirect()->route('articles.index')->with('success', 'Data deleted successfully.');
    }
}
