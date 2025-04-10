<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WriterApprovalController extends Controller
{
    // Tampilkan daftar user dengan role 'Pending Writer'
    public function index()
    {
        $pendingWritersCount = User::role('Pending Writer')->count();

        // Eager load the writer profiles with each pending writer
        $pendingWriters = User::role('Pending Writer')
            ->with('writerProfile')
            ->get();

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

    // Add this method to WriterApprovalController.php
    public function reject(User $user, Request $request)
    {
        if ($user->hasRole('Pending Writer')) {
            $user->removeRole('Pending Writer');
            $user->assignRole('Rejected Writer'); // lamun di reject role na jadi guest biasa

            if ($user->writerProfile) {
                $user->writerProfile->update([
                    'status'           => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                ]);
            }

            return redirect()->route('admin.pending-writers')
                ->with('success', "{$user->name}'s writer application has been rejected.");
        }

        return redirect()->back()->with('error', "User is not a Pending Writer.");
    }
}
