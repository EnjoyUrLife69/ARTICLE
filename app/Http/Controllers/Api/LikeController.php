<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Toggle like/unlike artikel
    public function toggleLike(Request $request, $id)
    {
        // Cari artikel
        $article = Article::find($id);

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found',
            ], 404);
        }

        // Dapatkan user dari request
        $user = $request->user();

        // Cek apakah sudah like
        $like = Like::where('user_id', $user->id)
            ->where('article_id', $article->id)
            ->first();

        // Toggle like/unlike
        if ($like) {
            // Unlike
            $like->delete();
            $action = 'unliked';
            $liked  = false;
        } else {
            // Like (UUID akan otomatis di-generate oleh model)
            Like::create([
                'user_id'    => $user->id,
                'article_id' => $article->id,
            ]);
            $action = 'liked';
            $liked  = true;
        }

        // Hitung jumlah like terbaru
        $likeCount = Like::where('article_id', $article->id)->count();

        // Update artikel
        $article->like_count = $likeCount;
        $article->save();

        return response()->json([
            'success'    => true,
            'message'    => "Article {$action} successfully",
            'liked'      => $liked,
            'like_count' => $likeCount,
        ]);
    }

    // Cek status like artikel
    public function checkLikeStatus(Request $request, $id)
    {
        // Cari artikel
        $article = Article::find($id);

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found',
            ], 404);
        }

        // Dapatkan user dari request
        $user = $request->user();

        // Cek apakah sudah like
        $isLiked = Like::where('user_id', $user->id)
            ->where('article_id', $article->id)
            ->exists();

        return response()->json([
            'success'  => true,
            'is_liked' => $isLiked,
        ]);
    }
}
