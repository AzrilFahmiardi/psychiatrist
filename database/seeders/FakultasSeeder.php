<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemenData = [
            [
                'name' => 'DTEDI',
                'program_studis' => [
                    'Teknologi Rekayasa Perangkat Lunak',
                    'Teknologi Rekayasa Elektro',
                    'Teknologi Rekayasa Instrumentasi dan Kontrol',
                    'Teknologi Rekayasa Internet',
                ],
            ],
            [
                'name' => 'DTM',
                'program_studis' => [
                    'Teknologi Rekayasa Mesin',
                    'Teknik Pengelolaan dan Perawatan Alat Berat',
                ],
            ],
            [
                'name' => 'DEB',
                'program_studis' => [
                    'Manajemen dan Penilaian Properti',
                    'Perbankan',
                    'Akuntansi Sektor Publik',
                    'Pembangunan Ekonomi Kewilayahan',
                ],
            ],
        ];

        // Loop data untuk insert
        foreach ($departemenData as $departemen) {
            // Insert departemen
            $departemenId = DB::table('departemens')->insertGetId([
                'name' => $departemen['name'],
            ]);

            // Insert program studis untuk departemen tersebut
            foreach ($departemen['program_studis'] as $prodi) {
                DB::table('program_studis')->insert([
                    'name' => $prodi,
                    'departemen_id' => $departemenId,
                ]);
            }
        }
    }
}
