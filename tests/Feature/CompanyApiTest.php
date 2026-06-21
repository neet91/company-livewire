<?php

use App\Models\CompanyAlpine;
use App\Models\Employee;

test('a single company can be fetched with employees and employee count without authentication', function () {
    $company = CompanyAlpine::factory()->create([
        'name' => 'Acme Corporation',
        'email' => 'acme@example.com',
        'website' => 'https://acme.test',
        'logo' => null,
    ]);

    Employee::factory()->for($company, 'company')->create([
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'email' => 'ada@example.com',
        'phone' => '555-0101',
    ]);

    Employee::factory()->for($company, 'company')->create([
        'first_name' => 'Grace',
        'last_name' => 'Hopper',
        'email' => 'grace@example.com',
        'phone' => '555-0102',
    ]);

    $response = $this->getJson("/api/companies/{$company->id}");

    $response
        ->assertOk()
        ->assertJsonPath('data.id', $company->id)
        ->assertJsonPath('data.name', 'Acme Corporation')
        ->assertJsonPath('data.employee_count', 2)
        ->assertJsonCount(2, 'data.employees')
        ->assertJsonFragment([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'full_name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'phone' => '555-0101',
        ]);
});
