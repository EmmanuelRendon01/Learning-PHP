<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {

        $users = User::latest()->paginate(15);
        return view('users.index', compact('users'));
    }

    public function userById(User $user)
    {
        return view('users.details', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function createUser()
    {
        return view('users.createUser');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('users')->with('status', 'User updated');
    }

    public function save(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->route('users')
            ->with('status', 'User created successfully');
    }


    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('users')->with('status', 'Deleted correctly');
    }
}
