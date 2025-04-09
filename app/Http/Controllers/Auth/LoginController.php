<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        // Log roles untuk debugging
        Log::info('User Login:', [
            'name'  => $user->name,
            'roles' => $user->getRoleNames()->toArray(),
        ]);

        if ($user->hasRole('Super Admin')) {
            return '/dashboard/admin/dashboard';
        } elseif ($user->hasRole('Writer')) {
            return '/dashboard/writer/dashboard';
        } else {
            return '/';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
