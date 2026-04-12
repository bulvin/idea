<?php

use App\Models\User;

it('creates a new idea', function () {

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://google.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'Example Title',
        'status' => 'completed',
        'description' => 'An example description',
        'links' => ['https://google.com', 'https://laravel.com']
    ]);
});
