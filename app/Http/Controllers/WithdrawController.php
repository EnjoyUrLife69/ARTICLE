<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the withdrawals.
     */
    public function index()
    {
        $user = Auth::user();

        // Dapatkan semua permintaan penarikan user
        $withdraws = Withdraw::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung total saldo
        $articles = Article::where('user_id', $user->id)
            ->where('status', 'approved')
            ->get();

        $totalEarnings = $articles->sum('total');

        // Hitung total yang sudah ditarik
        $totalWithdrawn = Withdraw::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'processing'])
            ->sum('amount');

        // Saldo yang tersedia
        $availableBalance = $totalEarnings - $totalWithdrawn;

        return view('withdraw.index', compact('withdraws', 'totalEarnings', 'totalWithdrawn', 'availableBalance'));
    }

    /**
     * Show the form for creating a new withdrawal.
     */
    public function create()
    {
        $user = Auth::user();

        // Hitung total saldo
        $articles = Article::where('user_id', $user->id)
            ->where('status', 'approved')
            ->get();

        $totalEarnings = $articles->sum('total');

        // Hitung total yang sudah ditarik
        $totalWithdrawn = Withdraw::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'processing'])
            ->sum('amount');

        // Saldo yang tersedia
        $availableBalance = $totalEarnings - $totalWithdrawn;

        // Set nilai minimum penarikan yang masuk akal
        $minWithdraw = min(10000, $availableBalance);

        return view('withdraw.create', compact('availableBalance', 'minWithdraw'));
    }

    /**
     * Store a newly created withdrawal in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Hitung saldo yang tersedia
        $articles = Article::where('user_id', $user->id)
            ->where('status', 'approved')
            ->get();

        $totalEarnings = $articles->sum('total');

        $totalWithdrawn = Withdraw::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'processing'])
            ->sum('amount');

        $availableBalance = $totalEarnings - $totalWithdrawn;

        // Set nilai minimum penarikan yang masuk akal
        // Jika saldo tersedia kurang dari 10.000, minimal penarikan adalah seluruh saldo
        // Jika saldo tersedia lebih dari 10.000, minimal penarikan adalah 10.000
        $minWithdraw = min(10000, $availableBalance);

        // Validasi request
        $request->validate([
            'amount'         => 'required|numeric|min:' . $minWithdraw . '|max:' . $availableBalance,
            'payment_method' => 'required|in:bank_transfer,e-wallet',
            'bank_name'      => 'required_if:payment_method,bank_transfer',
            'account_number' => 'required_if:payment_method,bank_transfer',
            'account_name'   => 'required_if:payment_method,bank_transfer',
            'ewallet_type'   => 'required_if:payment_method,e-wallet',
            'phone_number'   => 'required_if:payment_method,e-wallet',
        ], [
            'amount.min' => 'Minimal penarikan adalah Rp. ' . number_format($minWithdraw, 0, ',', '.'),
            'amount.max' => 'Saldo tersedia hanya Rp. ' . number_format($availableBalance, 2, ',', '.'),
        ]);

        // Simpan data penarikan
        $withdraw                 = new Withdraw();
        $withdraw->id             = (string) Str::uuid();
        $withdraw->user_id        = $user->id;
        $withdraw->amount         = $request->amount;
        $withdraw->payment_method = $request->payment_method;

        if ($request->payment_method == 'bank_transfer') {
            $withdraw->bank_name      = $request->bank_name;
            $withdraw->account_number = $request->account_number;
            $withdraw->account_name   = $request->account_name;
        } else {
            $withdraw->ewallet_type = $request->ewallet_type;
            $withdraw->phone_number = $request->phone_number;
        }

        $withdraw->status = 'pending';
        $withdraw->save();

        return redirect()->route('withdraw.index')->with('success', 'Permintaan penarikan dana berhasil diajukan!');
    }

    /**
     * Display the specified withdrawal.
     */
    public function show(Withdraw $withdraw)
    {
        // Pastikan hanya pemilik yang bisa melihat
        if (Auth::id() !== $withdraw->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('withdraw.show', compact('withdraw'));
    }

    /**
     * Cancel a pending withdrawal.
     */
    public function cancel(Withdraw $withdraw)
    {
        // Pastikan hanya pemilik yang bisa membatalkan
        if (Auth::id() !== $withdraw->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan status masih pending
        if ($withdraw->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya penarikan dengan status menunggu yang bisa dibatalkan.');
        }

        $withdraw->status = 'rejected';
        $withdraw->notes  = 'Dibatalkan oleh pengguna';
        $withdraw->save();

        return redirect()->route('withdraw.index')->with('success', 'Permintaan penarikan berhasil dibatalkan.');
    }
}
