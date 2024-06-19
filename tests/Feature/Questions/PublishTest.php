<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('should be able to publish a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    \Pest\Laravel\put(route('question.publish', $question))
        ->assertRedirect();

    $question->refresh();

    expect($question)
        ->draft->toBeFalse();
});

it('should make sure that only the person who has created a question can pubish the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question = Question::factory()->create(['draft' => false, 'created_by' => $rightUser]);
    actingAs($rightUser);

    \Pest\Laravel\put(route('question.publish', $question))
        ->assertRedirect();

    actingAs($wrongUser);

    \Pest\Laravel\put(route('question.publish', $question))
        ->assertForbidden();

});
