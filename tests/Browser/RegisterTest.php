<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;

it('registers a user', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'johndoe@gmail.com')
        ->fill('password', 'password123!@#')
        ->click('Create Account')
        ->assertRoute('ideas.index');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'John Doe',
        'email' => 'johndoe@gmail.com',
    ]);
});
