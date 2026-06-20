<?php

namespace Database\Factories;

use App\Models\CompanyAlpine;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => CompanyAlpine::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
