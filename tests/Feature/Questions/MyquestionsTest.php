<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\get;

it('should be able to list all questions created by me', function () {

    $wrongUser = User::factory()->create();

    $wrongQuestions = Question::factory()
        ->for($wrongUser, 'createdBy')
        ->count(10)
        ->create();

    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->count(10)
        ->create();

    \Pest\Laravel\actingAs($user);

    $response = get(route('question.index'));

    /** @var Question $q */
    foreach ($question as $q) {
        $response->assertSee($q->question);
    }

    /** @var Question $q */
    foreach ($wrongQuestions as $q) {
        $response->assertDontSee($q->question);
    }
});
