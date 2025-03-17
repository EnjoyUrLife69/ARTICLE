<?php
namespace App\Http\Controllers;

use App\Models\Activitie;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Super Admin');
    }

    public function index()
    {
        // Statistik konten
        $totalArticles    = Article::count();
        $pendingArticles  = Article::where('status', 'pending')->count();
        $approvedArticles = Article::where('status', 'approved')->count();
        $rejectedArticles = Article::where('status', 'rejected')->count();

        // Statistik pengguna
        $totalUsers  = User::role('Writer')->count();
        $activeUsers = User::role('Writer')
            ->whereHas('article', function ($query) {
                $query->whereDate('created_at', '>=', Carbon::now()->subDays(30));
            })
            ->count();

        // Statistik kategori
        $totalCategories = Categorie::count();
        $categoryStats   = Categorie::select('categories.*')
            ->join('articles', 'articles.categorie_id', '=', 'categories.id')
            ->selectRaw('COUNT(articles.id) as article_count')
            ->groupBy('categories.id')
            ->orderByDesc('article_count')
            ->limit(5)
            ->get();

        // Statistik engagement
        $totalViews  = Article::sum('view_count');
        $totalLikes  = Article::sum('like_count');
        $totalShares = Article::sum('share_count');

        // Artikel terbaru yang menunggu persetujuan
        $pendingReviewArticles = Article::where('status', 'pending')
            ->with(['user', 'categorie'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Aktivitas terbaru
        $recentActivities = Activitie::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Penulis paling aktif
        $topWriters = User::role('Writer')
            ->withCount(['article' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->orderByDesc('article_count')
            ->limit(5)
            ->get();

        // Data untuk chart bulanan
        $monthlyStats = Article::select(
            DB::raw('EXTRACT(MONTH FROM created_at) as month'),
            DB::raw('COUNT(*) as article_count'),
            DB::raw('SUM(view_count) as total_views')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months        = [];
        $articleCounts = [];
        $viewCounts    = [];

        foreach ($monthlyStats as $stat) {
            $months[]        = Carbon::createFromDate(date('Y'), $stat->month, 1)->format('M');
            $articleCounts[] = $stat->article_count;
            $viewCounts[]    = $stat->total_views;
        }

        return view('admin.dashboard', compact(
            'totalArticles',
            'pendingArticles',
            'approvedArticles',
            'rejectedArticles',
            'totalUsers',
            'activeUsers',
            'totalCategories',
            'categoryStats',
            'totalViews',
            'totalLikes',
            'totalShares',
            'pendingReviewArticles',
            'recentActivities',
            'topWriters',
            'months',
            'articleCounts',
            'viewCounts'
        ));
    }
}
