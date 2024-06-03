<?php

namespace App\Console\Commands;

use App\Models\Reservasi;
use App\Models\Reservasi_detail;
use Illuminate\Console\Command;

class UpdateBookingData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:mobil';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbarui data mobil';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = now();
        $bookings = Reservasi_detail::where('tanggal_ambil', '>', $currentTime)
            ->get();

        foreach ($bookings as $booking) {
            if ($booking->mobil) {
                // Ubah status mobil menjadi 'away'
                $booking->mobil->update(['status' => 'away']);
            }
        }

        $this->info('Data mobil berhasil diperbarui.');
    }
}
