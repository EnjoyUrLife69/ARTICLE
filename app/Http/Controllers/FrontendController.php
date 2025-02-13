<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\Comment;

class FrontendController extends Controller
{
    public function home()
    {
        $articles         = Article::all();
        $article_trending = Article::where('status', 'approved')
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $history = session()->get('article_history', []);
        // Jika history kosong, langsung buat collection kosong
        $article_history = collect();
        if (! empty($history)) {
            $article_history = Article::whereIn('id', $history)
                ->get()
                ->sortBy(function ($article) use ($history) {
                    return array_search($article->id, $history);
                });
        }

        $categories = Categorie::all();
        return view('frontend-page.homepage', compact('articles', 'article_trending', 'categories', 'article_history'));
    }
    public function details($id)
    {
        $articles         = Article::findOrFail($id);
        $article_trending = Article::where('status', 'approved')
            ->orderBy('view_count', 'desc')
            ->take(5)
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

}
