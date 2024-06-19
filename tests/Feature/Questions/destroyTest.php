<?php
use App\Models\User;
use App\Models\Question;
use function Pest\Laravel\actingAs;

it('should be able to destroy a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    \Pest\Laravel\delete(route('question.destroy', $question))
        ->assertRedirect();

    $question->refresh();

    expect($question)
        ->draft->toBeFalse();
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
