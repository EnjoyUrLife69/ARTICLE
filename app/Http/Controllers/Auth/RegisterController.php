<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        // Log roles untuk debugging
        Log::info('User Register:', [
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        
        // Add conditional validation for writer fields
        if (isset($data['wants_to_be_writer']) && $data['wants_to_be_writer']) {
            $rules['bio'] = ['required', 'string'];
            $rules['motivation'] = ['required', 'string'];
            // Previous work is optional
        }
        
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Create user as before
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Assign appropriate role
        if (isset($data['wants_to_be_writer']) && $data['wants_to_be_writer']) {
            $user->assignRole('Pending Writer');
            
            // Create writer profile
            $user->writerProfile()->create([
                'bio' => $data['bio'] ?? null,
                'previous_work' => $data['previous_work'] ?? null,
                'motivation' => $data['motivation'] ?? null,
                'status' => 'pending'
            ]);
        } else {
            $user->assignRole('Guest');
        }

        return $user;
    }
}
