<?php
namespace App\Http\Controllers;

use App\Models\Activitie;
use App\Models\Article;
use App\Models\ArticleMedia;
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

    public function approve($id)
    {
        $article         = Article::findOrFail($id);
        $article->status = 'approved';
        $article->save();

        // Kirim notifikasi ke penulis
        Notification::create([
            'user_id' => $article->user_id,
            'title'   => 'Article Approved',
            'message' => "Your Article titled '{$article->title}' has been Approved.",
        ]);

        return redirect()->route('request')->with('success', 'The article has been Approved');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'review_notes' => 'required|string', // Validasi review notes
        ]);

        $article         = Article::findOrFail($id);
        $article->status = 'rejected';
        $article->save();

        Notification::create([
            'user_id'      => $article->user_id,
            'title'        => 'Article Rejected',
            'message'      => "Your Article titled '{$article->title}' has been Rejected.",
            'review_notes' => $request->input('review_notes'),
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('request')->with('success', 'Article rejected with feedback.');
    }

    public function request()
    {
        $categories = Categorie::all();
        $articles   = Article::where('status', 'pending')->get(); // Hanya artikel yang statusnya 'pending'

        return view('articles.request', compact('articles', 'categories'));
    }

    public function index()
    {
        $categories = Categorie::all();

        if (auth()->user()->hasRole('Super Admin')) {
            $articles = Article::orderBy('created_at', 'desc')->where('status', 'approved')->get();
        } else {
            $articles = Article::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $approvedArticlesCount = Article::where('status', 'approved')->count();

        return view('articles.index', compact('articles', 'categories', 'approvedArticlesCount'));
    }

    public function create()
    {
        $categories = Categorie::orderBy('name', 'asc')->get();

        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'               => 'required',
            'content'             => 'required',
            'cover'               => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'categorie_id'        => 'required',
            'description'         => 'required',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'youtube_link'        => 'nullable|url',
        ]);

        $article               = new Article();
        $article->title        = $request->input('title');
        $article->release_date = Carbon::today();
        $article->description  = $request->input('description');
        $article->content      = $request->input('content');
        $article->categorie_id = $request->input('categorie_id');
        $article->user_id      = auth()->user()->id;
        $article->status       = $request->input('status') ?? 'pending';

        if ($request->hasFile('cover')) {
            $image     = $request->file('cover');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Simpan gambar ke storage/app/public/images/articles
            $path = $image->storeAs('images/articles', $imageName);

            // Menyimpan nama file ke database
            $article->cover = $imageName;
        }

        // Save the article first to get the ID
        $article->save();

        // Process additional images if any
        if ($request->hasFile('additional_images')) {
            $additionalImages = $request->file('additional_images');
            $order            = 1;

            // Limit to max 5 images
            foreach (array_slice($additionalImages, 0, 5) as $image) {
                $imageName = $article->id . '-' . time() . '-' . $order . '.' . $image->getClientOriginalExtension();

                // Store the image
                $path = $image->storeAs('images/articles/additional', $imageName);

                // Create media record
                ArticleMedia::create([
                    'article_id' => $article->id,
                    'type'       => 'image',
                    'path'       => $imageName,
                    'order'      => $order,
                ]);

                $order++;
            }
        }

        // Process YouTube link if provided
        if ($request->filled('youtube_link')) {
            $youtubeLink = $request->input('youtube_link');

            // Extract YouTube video ID if needed
            // This is a simple extraction, you might want to improve it
            $videoId = $youtubeLink;

            // If it's a full YouTube URL, extract the ID
            if (strpos($youtubeLink, 'youtube.com') !== false || strpos($youtubeLink, 'youtu.be') !== false) {
                // Extract video ID from YouTube URL
                if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $youtubeLink, $matches)) {
                    $videoId = $matches[1];
                }
            }

            // Create media record for YouTube
            ArticleMedia::create([
                'article_id' => $article->id,
                'type'       => 'youtube',
                'path'       => $videoId,
                'order'      => 0, // YouTube videos can be order 0
            ]);
        }

        Activitie::create([
            'user_id'        => auth()->id(),
            'action'         => 'create',
            'article_id'     => $article->id,
            'details'        => "Created an article with the title <b>'{$article->title}'</b>",
            'img'            => $article->cover,
            'description'    => $article->description,
            'categorie_name' => $article->categorie ? $article->categorie->name : 'No category',
        ]);

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
            'title'               => 'required',
            'content'             => 'required',
            'cover'               => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'categorie_id'        => 'required',
            'description'         => 'required',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'youtube_link'        => 'nullable|url',
        ]);

        $article               = Article::findOrFail($id);
        $article->title        = $request->input('title');
        $article->release_date = Carbon::today();
        $article->description  = $request->input('description');
        $article->content      = $request->input('content');
        $article->categorie_id = $request->input('categorie_id');
        $article->user_id      = auth()->user()->id;

        // Cek status artikel
        if ($article->status === 'approved') {
            $article->status = 'approved';
        } elseif ($article->status === 'rejected') {
            $article->status = 'pending';
        } else {
            $article->status = $request->input('status') ?? 'pending';
        }

        if ($request->hasFile('cover')) {
            $image     = $request->file('cover');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Simpan gambar baru ke storage
            $path = $image->storeAs('images/articles', $imageName);

            // Periksa apakah cover lama digunakan di aktivitas lain
            if ($article->cover && ! Activitie::where('img', $article->cover)->exists()) {
                Storage::delete('images/articles/' . $article->cover);
            }

            // Simpan nama file baru ke database
            $article->cover = $imageName;
        }

        // Save the article first to update it
        $article->save();

        // Process YouTube link if provided
        if ($request->filled('youtube_link')) {
            $youtubeLink = $request->input('youtube_link');

            // Extract YouTube video ID if needed
            $videoId = $youtubeLink;

            // If it's a full YouTube URL, extract the ID
            if (strpos($youtubeLink, 'youtube.com') !== false || strpos($youtubeLink, 'youtu.be') !== false) {
                // Extract video ID from YouTube URL
                if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $youtubeLink, $matches)) {
                    $videoId = $matches[1];
                }
            }

            // Check if YouTube record already exists
            $youtubeMedia = ArticleMedia::where('article_id', $article->id)
                ->where('type', 'youtube')
                ->first();

            if ($youtubeMedia) {
                // Update existing record
                $youtubeMedia->path = $videoId;
                $youtubeMedia->save();
            } else {
                // Create new record
                ArticleMedia::create([
                    'article_id' => $article->id,
                    'type'       => 'youtube',
                    'path'       => $videoId,
                    'order'      => 0,
                ]);
            }
        } else {
            // If no YouTube link is provided, delete existing YouTube record
            ArticleMedia::where('article_id', $article->id)
                ->where('type', 'youtube')
                ->delete();
        }

        // Process additional images if any
        if ($request->hasFile('additional_images')) {
            $additionalImages = $request->file('additional_images');

            // Get current highest order
            $maxOrder = ArticleMedia::where('article_id', $article->id)
                ->where('type', 'image')
                ->max('order') ?? 0;

            $order = $maxOrder + 1;

            // Limit to max 5 images
            foreach (array_slice($additionalImages, 0, 5) as $image) {
                $imageName = $article->id . '-' . time() . '-' . $order . '.' . $image->getClientOriginalExtension();

                // Store the image
                $path = $image->storeAs('images/articles/additional', $imageName);

                // Create media record
                ArticleMedia::create([
                    'article_id' => $article->id,
                    'type'       => 'image',
                    'path'       => $imageName,
                    'order'      => $order,
                ]);

                $order++;
            }
        }

        Activitie::create([
            'user_id'        => auth()->id(),
            'action'         => 'edit',
            'article_id'     => $article->id,
            'details'        => "Edited an article with the title <b>'{$article->title}'</b>",
            'img'            => $article->cover,
            'description'    => $article->description,
            'categorie_name' => $article->categorie ? $article->categorie->name : 'No category',
        ]);

        return redirect()->route('articles.index')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $articles = Article::findOrFail($id);
        Activitie::create([
            'user_id'        => auth()->id(),
            'action'         => 'delete',
            'article_id'     => $articles->id,
            'details'        => "Deleted an article with the title <b>'{$articles->title}'</b>",
            'img'            => $articles->cover,
            'description'    => $articles->description,
            'categorie_name' => $articles->categorie ? $articles->categorie->name : 'No category',
        ]);

        $articles->delete();

        return redirect()->route('articles.index')->with('success', 'Data deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Jika query kosong, kembalikan ke halaman sebelumnya
        if (empty($query)) {
            return back();
        }

        $articles = Article::where('status', 'approved')
            ->where(function ($q) use ($query) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%" . strtolower($query) . "%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%" . strtolower($query) . "%"]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Categorie::all();

        return view('articles.search', compact('articles', 'categories', 'query'));
    }

}
