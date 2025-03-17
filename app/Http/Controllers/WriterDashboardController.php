<?php
namespace App\Http\Controllers;

use App\Models\Activitie;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WriterDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getNotifications()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->take(3)->get();
        $unreadCount = auth()->user()->notifications()->where('status', 'unread')->count();

        return view('backend.header', compact('notifications', 'unreadCount'));
    }

    public function index()
    {
        $user = auth()->user();

        // Statistik artikel
        $totalArticles    = Article::where('user_id', $user->id)->count();
        $approvedArticles = Article::where('user_id', $user->id)->where('status', 'approved')->count();
        $pendingArticles  = Article::where('user_id', $user->id)->where('status', 'pending')->count();
        $rejectedArticles = Article::where('user_id', $user->id)->where('status', 'rejected')->count();

        // Engagement metrics (menggunakan kolom dari model Article)
        $totalViews  = Article::where('user_id', $user->id)->sum('view_count');
        $totalLikes  = Article::where('user_id', $user->id)->sum('like_count');
        $totalShares = Article::where('user_id', $user->id)->sum('share_count');

        // Total pendapatan
        $totalEarnings = Article::where('user_id', $user->id)
            ->where('status', 'approved')
            ->get()
            ->sum('total');

        // Artikel berdasarkan kategori untuk chart
        $articlesByCategory = Categorie::select('categories.*')
            ->join('articles', 'articles.categorie_id', '=', 'categories.id')
            ->where('articles.user_id', $user->id) // Filter hanya artikel user yang login
            ->selectRaw('COUNT(articles.id) as total')
            ->groupBy('categories.id')
            ->orderBy('name', 'asc')
            ->get();

        // Format data untuk chart kategori
        $categoryLabels = $articlesByCategory->pluck('name')->toArray();
        $categoryData   = $articlesByCategory->pluck('total')->toArray();

        // Data untuk chart bulanan (6 bulan terakhir)
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $monthlyData  = Article::where('user_id', $user->id)
            ->where('created_at', '>=', $sixMonthsAgo)
            ->select(
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('COUNT(*) as article_count'),
                DB::raw('SUM(view_count) as view_count'),
                DB::raw('SUM(like_count) as like_count')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->get();

        // Format data untuk chart bulanan
        $months        = [];
        $articleCounts = [];
        $viewCounts    = [];
        $likeCounts    = [];

        foreach ($monthlyData as $data) {
            $monthName       = Carbon::createFromDate($data->year, $data->month, 1)->format('M');
            $months[]        = $monthName;
            $articleCounts[] = $data->article_count;
            $viewCounts[]    = $data->view_count;
            $likeCounts[]    = $data->like_count;
        }

        // Aktivitas terbaru
        $recentActivities = Activitie::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Artikel terbaru
        $recentArticles = Article::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Notifikasi terbaru
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('writer.dashboard', compact(
            'user',
            'totalArticles',
            'approvedArticles',
            'pendingArticles',
            'rejectedArticles',
            'totalViews',
            'totalLikes',
            'totalShares',
            'totalEarnings',
            'articlesByCategory',
            'categoryLabels',
            'categoryData',
            'months',
            'articleCounts',
            'viewCounts',
            'likeCounts',
            'recentActivities',
            'recentArticles',
            'notifications'
        ));
    }
}
