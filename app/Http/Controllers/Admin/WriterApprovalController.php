<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class WriterApprovalController extends Controller
{
    // Tampilkan daftar user dengan role 'Pending Writer'
    public function index()
    {
        $pendingWritersCount = User::role('Pending Writer')->count();

        $pendingWriters = User::role('Pending Writer')->get();
        return view('admin.pending-writers', compact('pendingWriters', 'pendingWritersCount'));
    }

    // Approve user jadi Writer
    public function approve(User $user)
    {
        if ($user->hasRole('Pending Writer')) {
            $user->removeRole('Pending Writer');
            $user->assignRole('Writer');

            // Optional: Tambahkan notifikasi
            // $user->notify(new WriterApprovedNotification());

            return redirect()->route('admin.pending-writers')->with('success', "{$user->name} has been approved as Writer.");
        }

        return redirect()->back()->with('error', "User is not a Pending Writer.");
    }
}
