<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activitie;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $path = $image->storeAs('images/users', $imageName, 'public');

            if ($user->image) {
                Storage::disk('public')->delete('images/users/' . $user->image);
            }
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile photo updated successfully.');
    }

    public function profile(Request $request)
    {
        $activities = Activitie::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        if ($request->ajax()) {
            return view('users.partials.activity', compact('activities'))->render();
        }

        $user = auth()->user();
        $roles = $user->getRoleNames();

        return view('users.profile', compact('user', 'roles', 'activities'));
    }

    public function index(Request $request): View
    {
        $data = User::all();
        $roles = Role::pluck('name', 'name')->all();

        // Menambahkan userRole untuk setiap user
        foreach ($data as $user) {
            $user->userRole = $user->roles->pluck('name', 'name')->all();
        }

        return view('users.index', compact('data', 'roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        // Tambahkan default image
        $input['image'] = $request->has('image') ? $request->file('image')->store('users', 'public') : 'default.jpg';

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'Data created successfully.');
    }

    public function show($id): View
    {
        $user = User::with('articles')->findOrFail($id);

        return view('users.index', compact('user'));
    }

    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password|nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'roles' => 'required', // Pastikan ada validasi untuk role
        ]);

        // Temukan data pengguna yang akan diupdate
        $user = User::findOrFail($id);

        // Update data pengguna
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Jika password diubah, lakukan enkripsi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Update role pengguna (hapus role lama, lalu assign role baru)
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        // Proses unggah gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Simpan gambar baru ke storage
            $image->storeAs('images/users', $imageName);

            // Hapus gambar lama jika ada
            if ($user->image) {
                Storage::delete('images/users/' . $user->image);
            }

            // Simpan nama file gambar baru ke database
            $user->image = $imageName;
        }

        // Simpan data pengguna yang sudah diupdate
        $user->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success', 'Data deleted successfully.');

    }
}
