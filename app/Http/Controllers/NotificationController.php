<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('notification.index', compact('notifications'));
    }

    public function destroy()
    {
        Notification::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'All notifications have been deleted.');
    }

}
