<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function home()
    {
        // Ambil semua artikel yang approved, tidak hanya 4 artikel
        $articles = Article::where('status', 'approved')
            ->get();

        $articless = Article::where('status', 'approved')
            ->take(6)
            ->get();

        $article_trending_slideshow = Article::where('status', 'approved')
            ->orderBy('view_count', 'desc')
            ->take(4)
            ->get();

        $article_trending = Article::where('status', 'approved')
            ->orderBy('view_count', 'desc')
            ->skip(4)
            ->take(4)
            ->get();

        $history         = session()->get('article_history', []);
        $article_history = collect();
        if (! empty($history)) {
            $article_history = Article::whereIn('id', $history)
                ->get()
                ->sortBy(function ($article) use ($history) {
                    return array_search($article->id, $history);
                });
        }

        $categories = Categorie::withCount('articles')
            ->orderByDesc('articles_count')
            ->skip(4)
            ->take(10)
            ->get();

        $popular_categories = Categorie::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(4)
            ->get();

        $articlesWithVideos = Article::whereHas('media', function ($query) {
            $query->where('type', 'youtube');
        })
            ->where('status', 'approved')
            ->latest('release_date')
            ->take(5)
            ->get();

        // Separate main video and sidebar videos
        $mainVideo     = $articlesWithVideos->first();
        $sidebarVideos = $articlesWithVideos->slice(1, 2);

        $history         = session()->get('article_history', []);
        $article_history = collect();
        if (! empty($history)) {
            $article_history = Article::whereIn('id', $history)
                ->get()
                ->sortBy(function ($article) use ($history) {
                    return array_search($article->id, $history);
                });
        }

        return view('frontend-page.homepage', compact('articles', 'articless' ,  'article_trending', 'categories', 'article_history', 'article_trending_slideshow', 'popular_categories', 'mainVideo', 'sidebarVideos'));
    }
    public function details($id)
    {
        $articles         = Article::findOrFail($id);
        $article_trending = Article::where('status', 'approved')
            ->orderBy('view_count', 'desc')
            ->take(4)
            ->get();
        $article    = Article::all();
        $categories = Categorie::all();
        $comments   = Comment::where('article_id', $id)->OrderBy('created_at', 'desc')->get();

        // HISTORY
        $history = session()->get('article_history', []);
        if (($key = array_search($id, $history)) !== false) {
            unset($history[$key]);
        }
        array_unshift($history, $id);
        session()->put('article_history', array_slice($history, 0, 5));

        // Nambah view 1+
        if (! session()->has('viewed_article_' . $id)) {
            $articles = Article::findOrFail($id);
            $articles->increment('view_count');
            session()->put('viewed_article_' . $id, true);
        }

        return view('frontend-page.detail', compact('articles', 'categories', 'article', 'comments', 'article_trending'));
    }

    public function toggleLike($id)
    {
        $user    = Auth::user();
        $article = Article::findOrFail($id);

        // Cek apakah user sudah like
        $existingLike = Like::where('user_id', $user->id)
            ->where('article_id', $article->id)
            ->first();

        if ($existingLike) {
            // Jika sudah like, hapus dari database (Unlike)
            $existingLike->delete();
            $article->decrement('like_count');
            return response()->json(['liked' => false]);
        } else {
            // Jika belum like, tambahkan ke database
            Like::create([
                'user_id'    => $user->id,
                'article_id' => $article->id,
            ]);
            $article->increment('like_count');
            return response()->json(['liked' => true]);
        }
    }

    public function updateShare($id)
    {
        $article = Article::findOrFail($id);
        $article->increment('share_count');

        return response()->json(['success' => true]);
    }

    public function category($id, Request $request)
    {
        // Ambil filter dari request, default 'latest'
        $filter = $request->input('filter', 'latest');

        // Validasi filter
        $validFilters = ['latest', 'most_viewed', 'most_liked', 'oldest'];
        $filter       = in_array($filter, $validFilters) ? $filter : 'latest';

        // Jika ID adalah 'all', alihkan ke method allArticles
        if ($id === 'all') {
            return $this->allArticles($request);
        }

        // Cari kategori
        $category = Categorie::findOrFail($id);

        // Query artikel berdasarkan kategori
        $query = Article::where('categorie_id', $category->id)
            ->where('status', 'approved');

        // Terapkan filter
        switch ($filter) {
            case 'most_viewed':
                $query->orderBy('view_count', 'desc');
                break;
            case 'most_liked':
                $query->orderBy('like_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Ambil artikel dengan pagination
        $articles = $query->paginate(9);

        // Data tambahan untuk sidebar
        $popular_categories = Categorie::withCount(['articles' => function ($query) {
            $query->where('status', 'approved');
        }])
            ->orderBy('articles_count', 'desc')
            ->take(6)
            ->get();

        $categories = Categorie::withCount(['articles' => function ($query) {
            $query->where('status', 'approved');
        }])
            ->orderBy('name')
            ->get();

        return view('frontend-page.category', compact(
            'category',
            'articles',
            'categories',
            'popular_categories',
            'filter'
        ));
    }

    public function allArticles(Request $request)
    {
        // Ambil filter dari request, default 'latest'
        $filter = $request->input('filter', 'latest');

        // Validasi filter
        $validFilters = ['latest', 'most_viewed', 'most_liked', 'oldest'];
        $filter       = in_array($filter, $validFilters) ? $filter : 'latest';

        // Query artikel
        $query = Article::where('status', 'approved');

        // Terapkan filter
        switch ($filter) {
            case 'most_viewed':
                $query->orderBy('view_count', 'desc');
                break;
            case 'most_liked':
                $query->orderBy('like_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Ambil artikel dengan pagination
        $articles = $query->paginate(9);

        // Data tambahan untuk sidebar
        $popular_categories = Categorie::withCount(['articles' => function ($query) {
            $query->where('status', 'approved');
        }])
            ->orderBy('articles_count', 'desc')
            ->take(6)
            ->get();

        $categories = Categorie::withCount(['articles' => function ($query) {
            $query->where('status', 'approved');
        }])
            ->orderBy('name')
            ->get();

        return view('frontend-page.category', compact(
            'articles',
            'categories',
            'popular_categories',
            'filter'
        ));
    }

}
