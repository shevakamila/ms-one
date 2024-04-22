<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\WebResponse;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use stdClass;

class AdminController extends Controller
{
    public function index()
    {
        $data = [];
        $data['user'] = Auth::user();
        $data['admins'] = User::where('role', 'admin')->latest()->get();
        $data['active'] = 'admins';
        return view('index.admin.admin.index', compact('data'))->with(['success' => "Berhasil menampilkan semua data admin"]);
    }


    public function pageFormStore()
    {
        $data['active'] = 'admins';
        $data['user'] = Auth::user();
        return view('index.admin.admin.form', compact('data'));
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
            $user->role = 'admin';
            $user->save();
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('img/user'), $imageName);
                $user->image = $imageName;
            }
            $user->save();

            DB::commit();
            return redirect('admin/admins')->with('success', 'Admin berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();


            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan admin, Silakan coba lagi.']);
        }
    }




    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            if (!$user) {
                return redirect()->back()->with('error', 'Data user tidak ditemukan.');
            }
            $user->delete();
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil menghapus user.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                "error" => "Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }



    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {

            if (!$user) {
                return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            }

            $validatedData = $request->validated();


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('img/admin', $imageName, 'public');
                $validatedData['image'] = $imagePath;
            }
            $user->update($validatedData);
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect('admin/admins/')->with('success', 'Data pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Tangani kesalahan
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data pengguna. Silakan coba lagi.']);
        }
    }
}
