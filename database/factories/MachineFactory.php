<?php

namespace Database\Factories;

use App\Models\Machine;
use App\Models\Plant;
use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Machine::class;

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
            'plant_id' => Plant::factory(),
            'published' => 'draft',
            'birthday' =>  $this->faker->date(),
            'published_at' => $this->faker->dateTime(),
            'active' => $this->faker->boolean(),
            'permissions' => [
                "create" => false,
                "read" => true,
                "update" => true,
                "delete" => false
            ],
            'country_code' => 'IT',
            'meta' => [
                "casa" => "chiesa",
                "auto" => "moto"
            ],
            'price' => $this->faker->randomFloat(2, 5, 100),
            'password' => $this->faker->word(),
            'size' => 'L',
            'longname' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->sentence(6),
            'biography' => $this->faker->sentence(6),
        ];
    }
}
