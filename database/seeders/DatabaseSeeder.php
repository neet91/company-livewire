<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyAlpine;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@admin.com',
        // ]);

        $companies = CompanyAlpine::factory(10)->create();

        Employee::factory()
            ->count(25)
            ->state(fn () => [
                'company_id' => $companies->random()->id,
            ])
            ->create();
    }
}
