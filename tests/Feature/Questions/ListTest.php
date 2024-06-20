<?php

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use function Pest\Laravel\actingAs;

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

it('should paginate the results', function () {
    $user = User::factory()->create();
    Question::factory()->count(20)->create();

   actingAs($user);

    $response = get(route('dashboard'))
        ->assertViewHas('questions', function($value){
            return $value instanceof \Illuminate\Pagination\LengthAwarePaginator && $value->count() == 10 ;
        });

});


