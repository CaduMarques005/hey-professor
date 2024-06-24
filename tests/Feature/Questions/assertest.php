<?php

use App\Models\Question;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should be able to search a question by text', function () {

    $user = \App\Models\User::factory()->create();
    $wrongQuestions = Question::factory()->create(['question' => 'Something else']);
    $question = Question::factory()->create(['question' => 'My question is?']);
    actingAs($user);

    $response = get(route('dashboard', ['search' => 'question']));

    $response->assertDontSee('Something else');
    $response->assertSee('My question is?');

});
