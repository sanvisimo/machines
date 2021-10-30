<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'expiration' => '2021-10-30',
            'machine_id' => 1,
            'description' => $this->faker->sentence(10),
            'type' => 'maintenance',
            'contract' => true,
            'fix_fee' => true,
            'active' => true,
            'periodicity' => 30,
            'element_id' => 1,
            'element_type' => 'App\Models\Machine'
        ];
    }
}
