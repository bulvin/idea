<?php

use App\Models\Idea;
use App\Models\User;

it('shows the initial input', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user);

    $idea = Idea::factory()->for($user)->create();

    visit(route('ideas.show', $idea))
        ->click('@edit-idea-button')
        ->assertValue('title', $idea->title)
        ->assertValue('description', $idea->description)
        ->assertValue('status', $idea->status->value);

});

it('edits an existing idea', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user);

    $idea = Idea::factory()->for($user)->create();

    visit(route('ideas.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://google.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->click('Update')
        ->assertRoute('ideas.show', [$idea]);

    $idea->refresh();

    expect($idea)->toMatchArray([
        'title' => 'Example Title',
        'status' => 'completed',
        'description' => 'An example description',
    ]);

    expect($idea->links)->toContain('https://google.com');

    expect($idea->steps)->toHaveCount(1)
        ->and($idea->steps->first()->description)->toBe('Do a thing');
});
