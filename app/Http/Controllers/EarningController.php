<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Earning;
use Illuminate\Http\Request;
use App\Models\Withdraw;

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

        // Hitung total earnings dari artikel
        $totalEarnings = $articles->sum('total');

        // Hitung earnings berdasarkan view, like, dan share
        $totalViewEarnings = $articles->sum(function ($article) {
            return $article->view_count * Article::VIEW_RATE;
        });

        $totalLikeEarnings = $articles->sum(function ($article) {
            return $article->like_count * Article::LIKE_RATE;
        });

        $totalShareEarnings = $articles->sum(function ($article) {
            return $article->share_count * Article::SHARE_RATE;
        });

        // Hitung total penarikan yang sudah dilakukan
        $totalWithdrawn = Withdraw::where('user_id', $userId)
            ->sum('amount');

        // Saldo yang tersedia setelah penarikan
        $availableBalance = $totalEarnings - $totalWithdrawn;

        return view('earning.index', compact('earnings', 'articles', 'totalEarnings', 'totalViewEarnings', 'totalLikeEarnings', 'totalShareEarnings', 'availableBalance'));
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
