<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;

class FrontendController extends Controller
{
    public function home()
    {
        $articles = Article::all();
        $categories = Categorie::all();
        return view('frontend-page.homepage', compact('articles', 'categories'));
    }
    public function details($id)
    {
        $articles = Article::findOrFail($id);
        $article = Article::all();
        $categories = Categorie::all();

        return view('frontend-page.detail', compact('articles', 'categories', 'article'));
    }

}
