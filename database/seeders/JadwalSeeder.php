<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::today(); 
        $psikologId = 1; 
        $slotsPerDay = 6; 
        $days = 7; 

        $schedules = [];

        for ($day = 0; $day < $days; $day++) {
            for ($slot = 0; $slot < $slotsPerDay; $slot++) {
                $schedules[] = [
                    'waktu' => $startDate->copy()->addDays($day)->addHours($slot+12),
                    'psikolog_id' => $psikologId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('jadwals')->insert($schedules);
            }
}
