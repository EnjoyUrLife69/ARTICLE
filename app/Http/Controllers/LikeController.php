<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike($articleId)
    {
        $article = Article::findOrFail($articleId);

        $user = Auth::user();
        $like = Like::where('user_id', $user->id)
            ->where('article_id', $article->id)
            ->first();

        if ($like) {
            $like->delete();
            return response()->json(['liked' => false]);
        } else {
            Like::create([
                'user_id'    => $user->id,
                'article_id' => $article->id,
            ]);
            return response()->json(['liked' => true]);
        }
    }

}
