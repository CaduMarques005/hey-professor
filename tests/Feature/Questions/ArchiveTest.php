<?php
use App\Models\User;
use function Pest\Laravel\actingAs;
use App\Models\Question;
use function Pest\Laravel\assertDatabaseMissing;

it('should be able to archive a question', function(){
    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    \Pest\Laravel\patch(route('question.archive', $question))
        ->assertRedirect();

    $question->refresh();



    \Pest\Laravel\assertSoftDeleted('questions', ['id' => $question->id]);
});

it('should make sure that only the person who has created a question can soft delete the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question = Question::factory()->create(['draft' => false, 'created_by' => $rightUser]);


    actingAs($wrongUser);

    \Pest\Laravel\patch(route('question.archive', $question))
        ->assertForbidden();

    actingAs($rightUser);

    \Pest\Laravel\patch(route('question.archive', $question))
        ->assertRedirect();

});
