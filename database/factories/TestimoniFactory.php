<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Mobil;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Process\FakeProcessResult;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimoni>
 */
class TestimoniFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'mobil_id' =>  Mobil::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'keterangan' => fake()->paragraph(2),
        ];
    }
}
