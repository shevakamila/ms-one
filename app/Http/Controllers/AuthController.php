<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function pageLogin()
    {
        return view('index.login');
    }

    public function pageRegistrasi()
    {
        return view('index.registrasi');
    }

    public function registrasi(UserStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            $validatedData['password'] = Hash::make($validatedData['password']);
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('img/user'), $imageName);
                $validatedData['image'] = $imageName;
            }

            $validatedData['id'] = Str::uuid();
            $validatedData['role'] = 'pengguna';
            $user = User::create($validatedData);
            DB::commit();
            return redirect('page-login')->with('success', 'Registrasi account berhasil');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();

            return redirect()->back()->withInput()->with(['error' => 'Gagal membuat account,silakan coba lagi nanti.']);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Periksa role
                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('homeAdmin');
                        break;
                    default:
                        return redirect()->route('home');
                        break;
                }
            } else {

                return redirect()->back()->with(['error' => 'Email atau kata sandi salah.']);
            }
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => 'Terjadi kesalahan. Silakan coba lagi nanti.']);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/page-login');
    }
}
