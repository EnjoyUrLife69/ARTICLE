<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Earning;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId   = auth()->id(); // Ambil ID user yang sedang login
        $earnings = Earning::where('user_id', $userId)->get();
        $articles = Article::where('status', 'approved')
            ->where('user_id', $userId) // Filter hanya artikel milik user yang login
            ->get();
        $totalEarnings = $articles->sum('total');

        // Rincian total per kategori
        $totalViewEarnings = $articles->sum(function ($article) {
            return $article->view_count * Article::VIEW_RATE;
        });

        $totalLikeEarnings = $articles->sum(function ($article) {
            return $article->like_count * Article::LIKE_RATE;
        });

        $totalShareEarnings = $articles->sum(function ($article) {
            return $article->share_count * Article::SHARE_RATE;
        });

        return view('earning.index', compact('earnings', 'articles', 'totalEarnings', 'totalViewEarnings', 'totalLikeEarnings', 'totalShareEarnings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Earning $earning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Earning $earning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Earning $earning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Earning $earning)
    {
        //
    }
}
