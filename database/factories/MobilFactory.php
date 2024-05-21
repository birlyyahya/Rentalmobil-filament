<?php

namespace Database\Factories;

use App\Models\Kategori;
use Faker\Provider\FakeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mobil>
 */
class MobilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));

        return [
            'nama_mobil' => $faker->vehicle(),
            'kategori_id' => Kategori::factory(),
            'kapasitas' => $faker->vehicleSeatCount(),
            'warna' => fake()->colorName(),
            'transmisi' => $faker->vehicleGearBoxType(),
            'jenis_bbm' => $faker->vehicleFuelType(),
            'deskripsi' => $faker->vehicleRegistration('[DR]{2}-[0-9]{5}'),
            'harga_sewa' => fake()->randomNumber(6, true),
            'status' => fake()->randomElement(['Ready', 'Away']),
        ];
    }
}
