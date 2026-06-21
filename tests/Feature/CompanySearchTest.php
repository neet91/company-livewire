<?php

use App\Models\CompanyAlpine;
use App\Models\Employee;
use App\Models\User;

test('users can search companies by name', function () {
    $user = User::factory()->create();

    CompanyAlpine::create([
        'name' => 'Acme Corporation',
        'email' => 'acme@example.com',
        'website' => 'https://acme.test',
        'logo' => null,
    ]);

    CompanyAlpine::create([
        'name' => 'Globex',
        'email' => 'globex@example.com',
        'website' => 'https://globex.test',
        'logo' => null,
    ]);

    $response = $this->actingAs($user)->get(route('companies.index', ['search' => 'Acme']));

    $response->assertOk();
    $response->assertSee('Acme Corporation');
    $response->assertDontSee('Globex');
});

test('company show page lists employees that belong to the company', function () {
    $user = User::factory()->create();
    $company = CompanyAlpine::factory()->create([
        'name' => 'Acme Corporation',
    ]);
    $otherCompany = CompanyAlpine::factory()->create([
        'name' => 'Globex',
    ]);

    Employee::factory()->for($company, 'company')->create([
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
    ]);
    Employee::factory()->for($otherCompany, 'company')->create([
        'first_name' => 'Grace',
        'last_name' => 'Hopper',
    ]);

    $response = $this->actingAs($user)->get(route('companies.show', $company));

    $response->assertOk();
    $response->assertSee('Ada');
    $response->assertSee('Lovelace');
    $response->assertDontSee('Grace');
    $response->assertDontSee('Hopper');
});
