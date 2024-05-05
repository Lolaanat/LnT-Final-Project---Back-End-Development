<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
    return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:12|confirmed',
            'phone' => 'required|string|min:13',
            'role' => 'required|string|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'required|string|min:6|max:12|confirmed',
            'phone' => 'required|string|min:13',
            'role' => 'required|string|in:admin,user',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:admin,user',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('users.index');
    }

    public function editRole(User $user)
    {
        return view('users.edit-role', compact('user'));
    }

    public function indexAdmin()
    {
        $users = User::where('role', 'admin')->get();
        return view('users.index-admin', compact('users'));
    }

    public function indexUser()
    {
        $users = User::where('role', 'user')->get();
        return view('users.index-user', compact('users'));
    }

    public function updateRoleToAdmin(User $user)
    {
        $user->update([
            'role' => 'admin',
        ]);

        return redirect()->route('users.index-admin');
    }
    
    public function updateRoleToUser(User $user)
    {
        $user->update([
            'role' => 'user',
        ]);
    
        return redirect()->route('users.index-user');
    }

    public function editRoleToAdmin(User $user)
    {
        return view('users.edit-role-to-admin', compact('user'));
    }

    public function editRoleToUser(User $user)
    {
        return view('users.edit-role-to-user', compact('user'));
    }
}

Route::resource('users', UserController::class);
