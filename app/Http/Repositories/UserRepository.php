<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;;

use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function indexAll()
    {
        $user =  User::latest()->get();

        return $user;
    }
    public function indexPengguna()
    {
        $student =  User::where('role', 'pengguna')->get();

        return $student;
    }

    public function indexAdmin()
    {
        $admin =  User::where('role', 'admin')->get();

        return $admin;
    }


    public function createUser(Request $request, $role = "pengguna")
    {
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'role' => $role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($data);

        return $user;
    }

    public function deleteUser(User $user)
    {
        if (!$user->exists()) {
            return redirect()->route('not-found');;
        }
        return $user->delete();
    }


    public function updateUser(Request $request, User $user)
    {

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;


        $user->save();

        return $user;
    }
}
