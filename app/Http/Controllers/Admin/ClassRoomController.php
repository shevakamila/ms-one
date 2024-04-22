<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassRoomController extends Controller
{
    public function index()
    {
        $data['user'] = Auth::user();
        $data['classRooms'] = ClassRoom::orderBy('name')->latest()->get();
        $data['active'] = 'classRooms';
        return view('index.admin.classRoom.index', compact('data'))->with(['success' => "Berhasil menampilkan semua data kelas"]);
    }



    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:225'
            ]);
            $validatedData['id'] = Str::uuid();
            $classRoom = ClassRoom::create($validatedData);
            DB::commit();
            return redirect()->back()->with('success', 'kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan kelas. Silakan coba lagi.']);
        }
    }

    public function delete(ClassRoom $classRoom)
    {
        DB::beginTransaction();
        try {
            // Periksa apakah data kelas ada sebelum dihapus
            if (!$classRoom) {
                return redirect()->back()->with('error', 'Data kelas tidak ditemukan.');
            }
            // Hapus kelas
            $classRoom->delete();
            DB::commit();
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Berhasil menghapus kelas.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                "error" => "Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }


    public function show(ClassRoom $classRoom)
    {
        try {
            if (!$classRoom) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
            $data['classRoom'] = $classRoom;
            $data['success'] =  "Berhasil menampilkan siswa";
            return response()->json(["data" => $data]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, ClassRoom $classRoom)
    {
        DB::beginTransaction();
        try {

            if (!$classRoom) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
            $validatedData = $request->validate([
                'name' => 'required|string|max:225'
            ]);
            $classRoom->update($validatedData);
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil mengupdate kelas.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                "error" => "Gagal mengupdate kelas,Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }
}
