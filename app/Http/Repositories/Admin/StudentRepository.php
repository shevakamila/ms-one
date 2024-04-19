<?php


namespace App\Http\Repositories\Admin;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentRepository
{
    public function index()
    {
        $student =  Student::latest()->get();

        return $student;
    }

    public function show(Student $student)
    {
        if (!$student) {
            return redirect()->route('notFound');
        }

        return $student;
    }
    public function create(Request $request)
    {
        $student = new Student();
        $student->name = $request->name;
        $student->nisn = $request->nisn;
        $student->gender = $request->gender;
        $student->birthdate = $request->birthdate;
        $student->image = $request->image;
        $student->save();

        // Beri respons bahwa data siswa berhasil dibuat
        return $student;
    }

    public function delete(Student $student)
    {
        if (!$student) {
            abort(Response::HTTP_NOT_FOUND, 'Siswa tidak ditemukan');
        }

        return $student->delete();
    }


    public function update(Request $request, Student $student)
    {

        $student->name = $request->name;
        $student->nisn = $request->nisn;
        $student->gender = $request->gender;
        $student->birthdate = $request->birthdate;
        $student->save();

        return $student;
    }
}
