<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Establishment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstablishmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Establishment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'name' => $this->faker->unique()->sentence(3),
            'piva' => $this->faker->unique()->word(),
            'cf'  => $this->faker->unique()->word(),
            'email' => $this->faker->email(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'fax' => $this->faker->phoneNumber(),
            'contact' => $this->faker->email(),
        ];
    }
}
