<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // Get all articles
    public function index()
    {
        $articles = Article::with(['categorie', 'user'])->get();

        // Tambahkan URL lengkap untuk cover
        $articles->transform(function ($article) {
            $article->cover = $article->cover ? asset("storage/{$article->cover}") : null;
            return $article;
        });

        return response()->json([
            'success' => true,
            'data'    => $articles,
        ], 200);
    }

    public function show($id)
    {
        $article = Article::with(['categorie', 'user'])->find($id);

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found',
            ], 404);
        }

        // Tambahkan URL lengkap untuk cover
        $article->cover = $article->cover ? asset("storage/{$article->cover}") : null;

        return response()->json([
            'success' => true,
            'data'    => $article,
        ], 200);
    }

    // Create new article
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'release_date' => 'required|date',
            'categorie_id' => 'required|uuid|exists:categories,id',
            'user_id'      => 'required|integer|exists:users,id',
            'cover'        => 'nullable|string',
            'description'  => 'required|string',
            'content'      => 'required|string',
            'status'       => 'required|in:approved,pending,rejected',
        ]);

        $article = Article::create([
            'id'           => Str::uuid(),
            'title'        => $request->title,
            'release_date' => $request->release_date,
            'categorie_id' => $request->categorie_id,
            'user_id'      => $request->user_id,
            'cover'        => $request->cover,
            'description'  => $request->description,
            'content'      => $request->content,
            'status'       => $request->status,
            'view_count'   => 0,
            'share_count'  => 0,
            'like_count'   => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Article created successfully',
            'data'    => $article,
        ], 201);
    }

    // Update article
    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found',
            ], 404);
        }

        $article->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Article updated successfully',
            'data'    => $article,
        ], 200);
    }

    // Delete article
    public function destroy($id)
    {
        $article = Article::find($id);

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found',
            ], 404);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article deleted successfully',
        ], 200);
    }
}
