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
        return view('home');
    }

    public function getNotifications()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->take(3)->get();
        $unreadCount = auth()->user()->notifications()->where('status', 'unread')->count();

        return view('backend.header', compact('notifications', 'unreadCount'));
    }
    

}
