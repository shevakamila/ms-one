<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Helper\WebResponse;
use App\Http\Repositories\Admin\StudentRepository;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Activity;
use App\Models\ClassRoom;
use App\Models\Payment;
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
            $user->id = Str::uuid();
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
            $student->id = Str::uuid();
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
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan siswa. Silakan coba lagi.']);
        }
    }

    public function pageFormUpdate(Student $student)
    {
        $data['classRoom'] = ClassRoom::orderBy('name')->latest()->get();
        $data['student'] = new StudentResource($student);
        $data['user'] = Auth::user();

        $data['active'] = 'students';
        return view('index.admin.student.form_update', compact('data'));
    }

    public function show(Student $student)
    {
        try {
            if (!$student) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
            $data['active'] = 'students';
            $data['user'] = Auth::user();
            $data['student'] = $student->load([
                'activities',
                'payments' => function ($query) use ($student) {
                    $query->where('student_id', $student->id);
                }
            ]);
            $data['activity_notRegistered'] = Activity::whereDoesntHave('students', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })->latest()->get();


            $data['info'] = [
                'total_pembayaran_amount' => $student->payments()->where('status', 'paid')->sum('amount'),
                'total_pembayaran_success' => $student->payments()->where('status', 'paid')->count(),
                'total_pembayaran_failed' => $student->payments()->where('status', 'failed')->count(),
                'total_kegiatan' => $student->activities()->count(),
                'total_kegiatan_paid' => $student->activities()->wherePivot('is_paid_off', true)->count(),
                'total_kegiatan_unpaid' => $student->activities()->wherePivot('is_paid_off', false)->count()
            ];

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

            // Perbarui data siswa
            $student->update([
                'nisn' => $validatedData['nisn'],
                'birthdate' => $validatedData['birthdate'],
                'class_room_id' => $validatedData['class_room_id'],
                'gender' => $validatedData['gender']
            ]);

            $student->user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);
            DB::commit();

            return redirect('admin/students/' . $student->id . "/detail-siswa")->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Tangani kesalahan
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data siswa. Silakan coba lagi.']);
        }
    }

    public function addActivityToStudent(Request $request, Student $student)
    {
        DB::beginTransaction();
        try {
            if (!$request->has('activities')) {
                return redirect()->back()->withErrors(['error' => 'Tidak ada kegiatan yang dipilih']);
            }

            $activities = $request->input('activities');

            foreach ($activities as $activityId) {
                $student->activities()->attach($activityId);
            }

            DB::commit();
            return redirect()->route('admin.studentDetail', ['student' => $student->id])->with('success', 'Kegiatan berhasil ditambahkan ke siswa');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan kegiatan ke siswa. Silakan coba lagi.']);
        }
    }

    public function deleteActivityFromStudent(Activity $activity, Student $student)
    {
        DB::beginTransaction();
        try {

            $student->activities()->detach($activity->id);

            DB::commit();
            return redirect()->route('admin.studentDetail', ['student' => $student->id])->with('success', 'Kegiatan berhasil dihapus dari siswa');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus kegiatan dari siswa. Silakan coba lagi.']);
        }
    }
}
