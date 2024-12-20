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
        //Definisikan start date dan psikolog_id
        $startDate = Carbon::parse('2024-12-20'); // Ubah dengan tanggal yang diinginkan
        $psikologId = 1; // Ubah dengan ID psikolog yang sesuai

        // Masukkan data jadwal
        DB::table('jadwals')->insert([
            ['waktu' => $startDate, 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addHour(5), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addHour(6), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addHour(7), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addHour(8), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addHour(9), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(1), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(1)->addHour(1), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(1)->addHour(2), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(1)->addHour(3), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(1)->addHour(4), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(1)->addHour(5), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(2), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(2)->addHour(1), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(2)->addHour(2), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(2)->addHour(3), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(2)->addHour(4), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
            ['waktu' => $startDate->copy()->addDay(2)->addHour(5), 'psikolog_id' => $psikologId, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
