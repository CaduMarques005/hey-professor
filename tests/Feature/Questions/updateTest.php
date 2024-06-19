<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('should be able to update a question', function () {
    $user = User::factory()->create();

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'updated question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)
        ->question->toBe('updated question?');
});




it('should make sure that only the person who has created a question can edit the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question = Question::factory()->create(['draft' => false, 'created_by' => $rightUser]);
    actingAs($wrongUser);

    get(route('question.edit', $question))
        ->assertForbidden()();

    actingAs($rightUser);

    get(route('question.edit', $question))
        ->assertSucessful();

});
