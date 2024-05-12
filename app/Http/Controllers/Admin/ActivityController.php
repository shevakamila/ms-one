<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Helper\WebResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Http\Repositories\Admin\ActivityRepository;
use App\Http\Requests\Activity\ActivityStoreRequest;
use App\Http\Requests\Activity\ActivityUpdateRequest;
use App\Models\Activity;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{

    public function index()
    {
        $data['user'] = Auth::user();
        $activities = Activity::latest()->get();
        $data['activities'] = ActivityResource::collection($activities);
        $data['active'] = 'activities';
        return view('index.admin.activity.index', compact('data'))->with(['success' => "Berhasil menampilkan semua data kegiatan"]);
    }

    public function pageFormStore()
    {
        $data['user'] = Auth::user();


        $data['active'] = 'activities';
        return view('index.admin.activity.form', compact('data'));
    }


    public function store(ActivityStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();
            $validatedData['id'] = Str::uuid();
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img/activity'), $imageName);
            $validatedData['image'] = $imageName;
            $activity = Activity::create($validatedData);

            if ($request->has('is_for_all_students')) {
                $students = Student::whereNotIn('id', $activity->students->pluck('id'))->get();

                $activity->students()->attach($students);
            }

            DB::commit();
            return redirect('admin/activities')->with('success', 'Kegiatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan kegiatan. Silakan coba lagi.']);
        }
    }



    public function show(Activity $activity)
    {
        try {
            $data['user'] = Auth::user();
            if (!$activity) {
                return redirect()->back()->with('error', 'Data kegiatan tidak ditemukan.');
            }
            $data['activity'] = $activity->load(['students']);

            $data['unregistered_students'] = ClassRoom::whereDoesntHave('students.activities', function ($query) use ($activity) {
                $query->where('activity_id', $activity->id);
            })->with('students')->get();

            $data['activity']['student_registered'] = $activity->students()->count();
            $data['activity']['student_not_paid'] = $activity->students()->wherePivot('is_paid_off', false)->count();
            $data['activity']['student_paid'] = $activity->students()->wherePivot('is_paid_off', true)->count();



            $data['active'] = 'activities';
            return view('index.admin.activity.detail', compact('data'));
        } catch (\Exception $e) {

            return redirect()->back()->with([
                "error" => "Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }

    public function delete(Activity $activity)
    {
        DB::beginTransaction();
        try {
            if (!$activity) {
                return redirect()->back()->with('error', 'Data kegiatan tidak ditemukan.');
            }
            // Hapus kegiatan
            $activity->delete();
            DB::commit();
            // Redirect dengan pesan sukses
            return redirect('/admin/activities')->with('success', 'Berhasil menghapus kegiatan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                "error" => "Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }


    public function pageFormUpdate(Activity $activity)
    {
        $data['user'] = Auth::user();
        $data['active'] = 'activities';
        $data['activity'] = $activity;
        return view('index.admin.activity.form_update', compact('data'));
    }

    public function update(ActivityUpdateRequest $request, Activity $activity)
    {
        DB::beginTransaction();
        try {

            if (!$activity) {
                return redirect()->back()->with('error', 'Data kegiatan tidak ditemukan.');
            }

            $validatedData = $request->validated();
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img/activity'), $imageName);
            $validatedData['image'] = $imageName;

            $activity->update($validatedData);
            DB::commit();

            return redirect('admin/activities/' . $activity->id . "/detail-kegiatan")->with('success', 'Data kegiatan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Tangani kesalahan
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data kegiatan. Silakan coba lagi.']);
        }
    }



    public function deleteStudentFromActivity(Activity $activity, Student $student)
    {
        DB::beginTransaction();
        try {
            if (!$activity || !$student) {
                return redirect()->back()->with('error', 'Data kegiatan atau siswa tidak ditemukan.');
            }

            $activity->students()->detach($student);
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil menghapus siswa dari kegiatan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                "error" => "Terjadi error server silakan kembali nanti",
                "info" => $e->getMessage()
            ]);
        }
    }

    public function addStudentToActivity(Request $request, Activity $activity)
    {
        DB::beginTransaction();
        try {
            if (!$request->has('students')) {
                return redirect()->back()->withErrors(['error' => 'Tidak ada siswa yang dipilih.']);
            }

            $students = $request->input('students');

            foreach ($students as $studentId) {
                $activity->students()->attach($studentId);
            }

            DB::commit();
            return redirect('admin/activities/' . $activity->id . "/detail-kegiatan")->with('success', 'Siswa berhasil ditambahkan ke kegiatan.');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan siswa ke kegiatan. Silakan coba lagi.']);
        }
    }
}
