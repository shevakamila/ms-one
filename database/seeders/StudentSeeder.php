<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $classRooms = ClassRoom::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            // Membuat pengguna baru
            $user = new User();
            $user->id = Str::uuid();
            $user->name = 'Student ' . ($i + 1);
            $user->email = 'student' . ($i + 1) . '@example.com';
            $user->password = Hash::make('password');
            $user->role = 'student';
            $user->save();
            $classRoomId = $classRooms[array_rand($classRooms)];
            $student = new Student();
            $student->id = Str::uuid();
            $student->nisn = 'NISN-' . Str::random(8);
            $student->birthdate = now()->subYears(rand(15, 20));
            $student->gender = rand(0, 1) ? 'male' : 'female';
            $student->unique_code = Str::random(8);
            $student->class_room_id = $classRoomId;
            $user->student()->save($student);
        }



        // $students = [
        //     [
        //         'name' => 'Ani',
        //         'nisn' => '1234567890',
        //         'email' => 'ani@example.com',
        //         'gender' => 'female',
        //         'class_room_id' => 1,
        //         'birthdate' => '2005-01-15',
        //     ],
        //     [
        //         'name' => 'Budi',
        //         'nisn' => '2345678901',
        //         'email' => 'budi@example.com',
        //         'gender' => 'male',
        //         'class_room_id' => 2,
        //         'birthdate' => '2004-03-20',
        //     ],
        //     [
        //         'name' => 'Citra',
        //         'nisn' => '3456789012',
        //         'email' => 'citra@example.com',
        //         'gender' => 'female',
        //         'class_room_id' => 2,
        //         'birthdate' => '2006-07-10',
        //     ],

        // ];


        // foreach ($students as $student) {
        //     DB::table('students')->insert($student);
        // }
    }
}
