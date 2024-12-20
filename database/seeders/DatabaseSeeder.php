<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Psikolog;  // Pastikan mengimpor model dengan namespace yang benar
use Database\Seeders\JadwalSeeder;
use Database\Seeders\FakultasSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menambahkan data user
        $user = User::create([
            'name' => 'Dr. Andi Wijaya',
            'email' => 'anakijummira@gmail.com',
            'password' => Hash::make('12345678'),
            'nama_lengkap' => 'Dr. Andi Wijaya, M.Psi.',
            'role' => 'psikolog',
        ]);

        // Menambahkan data ke tabel psikolog
        Psikolog::create([
            'user_id' => $user->id,
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
