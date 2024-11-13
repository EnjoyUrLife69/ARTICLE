<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{

    public function destroy($id)
    {
        // Cari notifikasi berdasarkan ID
        $notification = auth()->user()->notifications()->findOrFail($id);

        // Hapus notifikasi
        $notification->delete();

        return response()->json(['success' => 'Notification deleted successfully.']);
    }
}
