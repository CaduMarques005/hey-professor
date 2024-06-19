<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('should be able to like a question', function () {

    $user = User::factory()->create();
    $question = Question::factory()->create();

    actingAs($user);

    post(route('question.like', $question))
        ->assertRedirect();

    \Pest\Laravel\assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like' => 1,
        'unlike' => 0,
        'user_id' => $user->id,
    ]);
});

it('should not be able to like more than one time', function () {
    $user = User::factory()->create();
    $question = Question::factory()->create();

    actingAs($user);

    post(route('question.like', $question));
    post(route('question.like', $question));

    expect($user->votes()->where('question_id', '=', $question->id)->get())
        ->toHaveCount(1);
});

it('should be able to unlike the question', function () {

    $user = User::factory()->create();
    $question = Question::factory()->create();

    actingAs($user);

    post(route('question.unlike', $question))
        ->assertRedirect();

    \Pest\Laravel\assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like' => 0,
        'unlike' => 1,
        'user_id' => $user->id,
    ]);
});

it('should not be able to unlike more than one time', function () {
    $user = User::factory()->create();
    $question = Question::factory()->create();

    actingAs($user);

    post(route('question.unlike', $question));
    post(route('question.unlike', $question));

    expect($user->votes()->where('question_id', '=', $question->id)->get())
        ->toHaveCount(1);
});
