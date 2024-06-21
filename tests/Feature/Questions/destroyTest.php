<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertSoftDeleted;

it('should be able to destroy a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    \Pest\Laravel\put(route('question.archive', $question))
        ->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id]);

    expect($question)
        ->refresh()
        ->deleted_at->not->toBeNull();
});

it('should make sure that only the person who has created a question can destroy the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question = Question::factory()->create(['draft' => false, 'created_by' => $rightUser]);
    actingAs($rightUser);

    \Pest\Laravel\delete(route('question.destroy', $question))
        ->assertRedirect();

    actingAs($wrongUser);

    \Pest\Laravel\delete(route('question.destroy', $question))
        ->assertForbidden();

});
