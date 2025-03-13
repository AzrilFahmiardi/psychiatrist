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
                'name' => 'Departemen Teknik Elektro dan Informatika',
                'program_studis' => [
                    'Teknologi Rekayasa Perangkat Lunak',
                    'Teknologi Rekayasa Elektro',
                    'Teknologi Rekayasa Instrumentasi dan Kontrol',
                    'Teknologi Rekayasa Internet',
                ],
            ],
            [
                'name' => 'Departemen Teknik Mesin',
                'program_studis' => [
                    'Teknologi Rekayasa Mesin',
                    'Teknik Pengelolaan dan Perawatan Alat Berat',
                ],
            ],
            [
                'name' => 'Departemen Layanan dan Informasi Kesehatan',
                'program_studis' => [
                    'Manajemen Informasi Kesehatan',
                ],
            ],
            [
                'name' => 'Departemen Teknologi Kebumian',
                'program_studis' => [
                    'Teknologi Survei dan Pemetaan Dasar',
                    'Sistem Informasi Geografis',
                ],
            ],
            [
                'name' => 'Departemen Teknologi Hayati dan Veteriner',
                'program_studis' => [
                    'Pengelolaan Hutan',
                    'Teknologi Veteriner',
                    'Pengembangan Produk Agroindustri',
                ],
            ],
            [
                'name' => 'Departemen Teknik Sipil',
                'program_studis' => [
                    'Teknik Pengelolaan dan Pemeliharaan Infrastruktur Sipil',
                    'Teknologi Rekayasa Pelaksanaan Bangunan Sipil',
                ],
            ],
            [
                'name' => 'Departemen Ekonomika dan Bisnis',
                'program_studis' => [
                    'Manajemen dan Penilaian Properti',
                    'Perbankan',
                    'Akuntansi Sektor Publik',
                    'Pembangunan Ekonomi Kewilayahan',
                ],
            ],
            [
                'name' => 'Departemen Bahasa, Seni dan Manajemen Budaya',
                'program_studis' => [
                    'Pengelolaan Arsip dan Rekaman Informasi',
                    'Bahasa Inggris',
                    'Bisnis Perjalanan Wisata',
                    'Bahasa Jepang untuk Komunikasi Bisnis dan Profesional',
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
