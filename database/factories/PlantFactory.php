<?php

namespace Database\Factories;

use App\Models\Establishment;
use App\Models\Plant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(3),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'contact' => $this->faker->email(),
            'establishment_id' => Establishment::factory()
        ];
    }
}
