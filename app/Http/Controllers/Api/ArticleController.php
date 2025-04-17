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

        // Ubah cara mengambil URL cover
        $baseUrl = url('/storage/images/articles');
        $articles->transform(function ($article) use ($baseUrl) {
            if ($article->cover) {
                // Ambil hanya nama file jika cover berisi path lengkap
                $filename       = basename($article->cover);
                $article->cover = "{$baseUrl}/{$filename}";
            }
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

        // Ubah cara mengambil URL cover
        $baseUrl = url('/storage/images/articles');
        if ($article->cover) {
            // Ambil hanya nama file jika cover berisi path lengkap
            $filename       = basename($article->cover);
            $article->cover = "{$baseUrl}/{$filename}";
        }

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

    // ArticleController.php
    public function updateShareCount($articleId)
    {
        try {
            // Fetch the article by ID
            $article = Article::findOrFail($articleId);

            // Increment the share count
            $article->increment('share_count');

            // Return the updated share count
            return response()->json([
                'success'     => true,
                'share_count' => $article->share_count,
            ]);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'success' => false,
                'message' => 'Failed to update share count',
            ], 500);
        }
    }

}
