<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classRooms = [
            ['name' => "10 PPLG 1"],
            ['name' => "10 PPLG 2"],
            ['name' => "11 PPLG 1"],
            ['name' => "11 PPLG 2"],
            ['name' => "12 PPLG 1"],
            ['name' => "12 PPLG 2"],
            ['name' => "10 DKV 1"],
            ['name' => "11 DKV 2"],
        ];
        foreach ($classRooms as $class) {
            ClassRoom::create($class);
        }
    }
}
