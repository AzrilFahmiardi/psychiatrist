<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Psikolog;  // Pastikan mengimpor model dengan namespace yang benar
use Database\Seeders\JadwalSeeder;
use Database\Seeders\FakultasSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menambahkan data ke tabel psikolog
        Psikolog::create([
            'name' => 'Dr. Andi Wijaya',
            'nama_lengkap' => 'Dr. Andi Wijaya, M.Psi.',
            'email' => 'andi@psikolog.com',
        ]);

        // Menjalankan seeder lainnya
        $this->call(FakultasSeeder::class);
        $this->call(JadwalSeeder::class);

        // Menambahkan data user untuk testing
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
