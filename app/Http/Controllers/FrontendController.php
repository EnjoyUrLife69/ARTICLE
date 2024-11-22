<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\Comment;

class FrontendController extends Controller
{
    public function home()
    {
        $articles = Article::all();
        $article_trending = Article::where('status', 'approved')->take(4)->OrderBy('created_at', 'desc')->get();
        $categories = Categorie::all();
        return view('frontend-page.homepage', compact('articles', 'article_trending', 'categories'));
    }
    public function details($id)
    {
        $articles = Article::findOrFail($id);
        $article = Article::all();
        $categories = Categorie::all();
        $comments = Comment::where('article_id', $id)->OrderBy('created_at', 'desc')->get();

        // Nambah view 1+
        if (!session()->has('viewed_article_' . $id)) {
            $articles = Article::findOrFail($id);
            $articles->increment('view_count');
            session()->put('viewed_article_' . $id, true);
        }

        return view('frontend-page.detail', compact('articles', 'categories', 'article', 'comments'));
    }

}
