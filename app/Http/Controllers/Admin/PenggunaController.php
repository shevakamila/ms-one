<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenggunaController extends Controller
{
    public function index()
    {
        $data = [];
        $data['user'] = Auth::user();
        $data['pengguna'] = User::where('role', 'pengguna')->latest()->get();
        $data['active'] = 'pengguna';
        return view('index.admin.pengguna.index', compact('data'))->with(['success' => "Berhasil menampilkan semua data pengguna"]);
    }


    public function pageFormStore()
    {
        $data['active'] = 'pengguna';

        return view('index.admin.pengguna.form', compact('data'));
    }

    public function store(UserStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = new User();
            $user->id = Str::uuid();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->role = 'pengguna';
            $user->save();
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('img/user'), $imageName);
                $user->image = $imageName;
            }
            $user->save();
            DB::commit();
            return redirect('admin/pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan pengguna, Silakan coba lagi.']);
        }
    }
}
