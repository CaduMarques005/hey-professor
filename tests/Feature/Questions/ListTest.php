<?php

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('should list all the questions', function () {

    $user = \App\Models\User::factory()->create();

    $questions = Question::factory()->count(5)->create();
    \Pest\Laravel\actingAs($user);

    $response = get(route('dashboard'));

    // Verifique se a resposta contém o texto de cada pergunta
    foreach ($questions as $question) {
        $response->assertSee($question->question);
    }
});
