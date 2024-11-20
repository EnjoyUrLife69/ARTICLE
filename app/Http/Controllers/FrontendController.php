<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Comment;

class FrontendController extends Controller
{
    public function home()
    {
        $articles = Article::all();
        $article_trending = Article::take(4)->OrderBy('created_at', 'desc')->get();
        $categories = Categorie::all();
        return view('frontend-page.homepage', compact('articles', 'article_trending' , 'categories'));
    }
    public function details($id)
    {
        $articles = Article::findOrFail($id);
        $article = Article::all();
        $categories = Categorie::all();
        $comments = Comment::where('article_id', $id)->OrderBy('created_at', 'desc')->get();

        return view('frontend-page.detail', compact('articles', 'categories', 'article', 'comments'));
    }

}
