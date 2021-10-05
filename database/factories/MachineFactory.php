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
            'manufacturer_code' => $this->faker->isbn10(),
            'manufacturer_description' => $this->faker->text(40),
            'type' => $this->faker->text(5),
            'serial_number' => $this->faker->text(20),
            'revision' => $this->faker->text(5),
            'state' =>  'active',
            'power' => $this->faker->randomFloat(2,0, 150),
            'engine_side_rpm' => $this->faker->randomFloat(2,0, 150),
            'process_side_rpm' =>$this->faker->randomFloat(2,0, 150),
            'pressure_min' =>$this->faker->randomFloat(2,0, 150),
            'pressure_max' =>$this->faker->randomFloat(2,0, 150),
            'temperature_min' =>$this->faker->randomFloat(2,0, 150),
            'temperature_max' =>$this->faker->randomFloat(2,0, 150),
            'documentation' =>$this->faker->imageUrl(),
            'activation_date' =>$this->faker->date(),
            'note' =>$this->faker->sentence(),
            'internal_note' =>$this->faker->sentence(),
        ];
    }
}
