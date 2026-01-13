<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\DB;

class FixBookingKonsultasiData extends Command
{
    protected $signature = 'fix:booking-konsultasi';
    protected $description = 'Fix booking completed tanpa konsultasi di database';

    public function handle()
    {
        $this->info('🔍 Mengecek data inconsistent...');
        
        // Cari booking completed tanpa konsultasi
        $orphanedBookings = Booking::where('status', 'completed')
            ->doesntHave('konsultasi')
            ->get();
        
        $count = $orphanedBookings->count();
        
        if ($count === 0) {
            $this->info('✅ Database sudah bersih! Tidak ada booking completed tanpa konsultasi.');
            return 0;
        }
        
        $this->warn("⚠️  Ditemukan {$count} booking completed tanpa konsultasi:");
        
        // Tampilkan detail
        $this->table(
            ['Booking ID', 'Pasien ID', 'Psikolog ID', 'Jadwal ID', 'Created At'],
            $orphanedBookings->map(fn($b) => [
                $b->id,
                $b->pasien_id,
                $b->psikolog_id,
                $b->jadwal_id,
                $b->created_at->format('Y-m-d H:i:s')
            ])
        );
        
        // Konfirmasi
        if (!$this->confirm('Apakah Anda ingin membuat konsultasi placeholder untuk booking ini?', true)) {
            $this->info('Operasi dibatalkan.');
            return 1;
        }
        
        // Fix data dengan transaction
        try {
            DB::beginTransaction();
            
            $fixed = 0;
            foreach ($orphanedBookings as $booking) {
                Konsultasi::create([
                    'booking_id' => $booking->id,
                    'hasil_konsultasi' => 'Hasil konsultasi tidak tersedia (data recovery).'
                ]);
                $fixed++;
                $this->line("✓ Fixed booking ID: {$booking->id}");
            }
            
            DB::commit();
            
            $this->info("\n✅ Berhasil memperbaiki {$fixed} booking!");
            $this->info('Database sekarang sudah konsisten.');
            
            return 0;
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
