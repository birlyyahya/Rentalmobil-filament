<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Faker\Provider\FakeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        $this->faker->addProvider(new FakeCar($this->faker));


        $title = $this->faker->unique()->vehicleType();
        $slug = Str::slug($title, '-');

        return [
            'kategori_mobil' => $title,
            'kategori_slug' => $slug,
            'deskripsi_kategori' => fake()->paragraph(2),
        ];
    }
}
