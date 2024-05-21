<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use \Faker\Provider\id_ID\Person as PersonId;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 *
 */
/* @var $factory \Illuminate\Database\Eloquent\Factory */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new PersonId($faker));

        return [
            'no_identitas' => $faker->nik(),
            'jenis_identitas' => $faker->randomElement(['KTP', 'SIM']),
            'nama_lengkap' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'alamat' => $faker->address(),
            'telp' => fake()->phoneNumber(),
            'password' => Hash::make('12345678'),
            'avatar' => 'customer_avatar/avatardefault.png',
            'status' => fake()->randomElement(['active', 'nonactive']),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
