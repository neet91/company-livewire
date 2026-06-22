<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyAlpine;
use App\Models\Employee;
use App\Models\User;

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
        //     'name' => 'Endministrator',
        //     'email' => 'admin@admin.com',
        // ]);

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Endministrator',
                'password' => bcrypt('password'),
            ]
        );

        $companies = CompanyAlpine::factory(12)->create();

        Employee::factory()
            ->count(20)
            ->state(fn () => [
                'company_id' => $companies->random()->id,
            ])
            ->create();
    }
}
