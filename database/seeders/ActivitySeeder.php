<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            'Lomba Cerdas Cermat',
            'Olimpiade Sains',
            'Pentas Seni Sekolah',
            'Pramuka Siaga',
            'Pekan Olahraga',
            'Penggalangan Dana Amal',
            'Pelatihan Keterampilan',
            'Kunjungan Industri',
            'Seminar Pendidikan',
            'Perayaan Hari Raya Sekolah'
        ];

        // Loop untuk menambahkan data kegiatan
        foreach ($activities as $activity) {
            Activity::create([
                'id' => Str::uuid(),
                'name' => $activity,
                'description' => fake()->paragraph,
                'image' => 'onedek_depan.jpg',
                'due_date' => fake()->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d'),
                'amount' => fake()->numberBetween(10000, 1000000),
            ]);
        }
    }
}
