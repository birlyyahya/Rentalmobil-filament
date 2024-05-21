<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservasi>
 */
class ReservasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $creditCardDetails = fake()->creditCardDetails();
        return [
            // Customer::inRandomOrder()->id
            "customer_id" => Customer::factory(),
            "kode_transaksi" => fake()->unique()->numerify("####"),
            "total_bayar" => fake()->numberBetween(250000, 600000),
            "status_reservasi" => fake()->randomElement(['diproses', 'diterima', 'menunggu', 'ditolak']),
            "status_pembayaran" => fake()->randomElement(['paid', 'unpaid', 'expired', 'refund']),
            "keterangan" => json_encode($creditCardDetails),
        ];
    }
}
