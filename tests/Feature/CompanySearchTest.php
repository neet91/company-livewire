<?php

use App\Models\CompanyAlpine;
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
