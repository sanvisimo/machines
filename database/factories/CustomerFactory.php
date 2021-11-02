<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_code' => $this->faker->unique()->isbn10(),
            'customer_name' => $this->faker->word(),
            'other_customer_name' => $this->faker->word(),
            'iso' => $this->faker->numerify('###'),
            'vat_number' => $this->faker->numerify('##########'),
            'fiscal_code' => $this->faker->bothify('??????##?##F###?'),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'po_box' => $this->faker->postcode(),
            'province' => $this->faker->stateAbbr(),
            'country' => $this->faker->countryCode(),
            'crm_c4c_code' => $this->faker->isbn13(),
            'type' => 'customer',
            'phone' => $this->faker->phoneNumber(),
            'fax' => $this->faker->phoneNumber(),
            'email'  => $this->faker->email(),
            'contact_person'  => $this->faker->name(),
            'activation_date'  => $this->faker->date(),
            'language' => $this->faker->languageCode(),
            'note' => $this->faker->sentence(8),
            'main_activity' => $this->faker->word(),
        ];
    }
}
