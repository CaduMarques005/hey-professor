<?php
use App\Models\Question;
use App\Models\User;

it('should be able to publish a question', function () {


    $user = User::factory()->create();
    $question = Question::factory()->create(['draft' => true]);
    \Pest\Laravel\actingAs($user);


    \Pest\Laravel\put(route('question.publish', $question))
    ->assertRedirect();

    $question->refresh();


    expect($question)
        ->draft->toBeFalse();
});
