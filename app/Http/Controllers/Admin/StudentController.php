<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Helper\WebResponse;
use App\Http\Repositories\Admin\StudentRepository;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;

class StudentController extends Controller
{
    public function index()
    {
        $data = [];
        $data['user'] = Auth::user();
        $students = Student::with(['activities', 'user'])->latest()->get();
        $data['students'] = StudentResource::collection($students);
        $data['active'] = 'students';
        return view('index.admin.student.index', compact('data'))->with(['success' => "Berhasil menampilkan semua data siswa"]);
    }


    public function pageFormStore()
    {

        $data['classRoom'] = ClassRoom::orderBy('name')->latest()->get();
        $data['active'] = 'students';
        $data['user'] = Auth::user();
        return view('index.admin.student.form', compact('data'));
    }


    public function store(StudentStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'student';
            $user->save();
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('img/user'), $imageName);
                $user->image = $imageName;
            }
            $user->save();

            $student = new Student();
            $student->nisn = $request->nisn;
            $student->birthdate = $request->birthdate;
            $student->class_room_id = $request->class_room_id;
            $student->gender = $request->gender;

            do {
                $unique_code = Str::random(8);
            } while (Student::where('unique_code', $unique_code)->exists());
            $student->unique_code = $unique_code;

            $user->student()->save($student);


            DB::commit();
            return redirect('admin/students')->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan siswa. Silakan coba lagi.']);
        }
    }

    public function pageFormUpdate(Student $student)
    {
        $data['classRoom'] = ClassRoom::orderBy('name')->latest()->get();
        $data['student'] = new StudentResource($student);
        $data['user'] = Auth::user();
        return view('index.admin.student.form_update', compact('data'));
    }

    public function show(Student $student)
    {
        try {
            if (!$student) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
            $data['student'] = new StudentResource($student);
            return view('index.admin.student.detail', compact('data'))->with(['success' => "Berhasil menampilkan siswa"]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                "error" => "Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }

    public function delete(Student $student)
    {
        DB::beginTransaction();
        try {
            // Periksa apakah data siswa ada sebelum dihapus
            if (!$student) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
            // Hapus siswa
            $student->delete();
            DB::commit();
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Berhasil menghapus siswa.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                "error" => "Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }



    public function update(StudentUpdateRequest $request, Student $student)
    {
        DB::beginTransaction();
        try {
            // Periksa apakah data siswa ada sebelum dihapus
            if (!$student) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
            $validatedData = $request->validated();
            $student->update($validatedData);
            DB::commit();

            return redirect('admin/students/' . $student->id . "/detail-siswa")->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Tangani kesalahan
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data siswa. Silakan coba lagi.']);
        }
    }
}
