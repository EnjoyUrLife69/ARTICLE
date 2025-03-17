<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Writer')) {
            return redirect()->route('writer.dashboard');
        } else {
            // default jika tidak punya role yang sesuai
            return redirect('/login')->with('error', 'Role not recognized.');
        }

    }

    public function getNotifications()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->take(3)->get();
        $unreadCount   = auth()->user()->notifications()->where('status', 'unread')->count();

        return view('backend.header', compact('notifications', 'unreadCount'));
    }

}
