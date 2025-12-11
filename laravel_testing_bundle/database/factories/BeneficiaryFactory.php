<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BeneficiaryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->randomElement(['059','056']).$this->faker->numerify('#######'),
            'service_type' => $this->faker->randomElement(['Food Aid','Cash Aid','Medical Aid']),
        ];
    }
}