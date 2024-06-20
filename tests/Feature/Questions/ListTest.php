<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        ->assertViewHas('questions', function ($value) {
            return $value instanceof \Illuminate\Pagination\LengthAwarePaginator && $value->count() == 10;
        });

});

it('should order by like and unlike, most liked question should be at the top, most unliked question must be on the bottom', function () {
    $user = User::factory()->create();
    $secondUser = User::factory()->create();
   $questions =  Question::factory()->count(20)->create();
   $mostLikedQuestions = Question::find(3);
   $mostUnlikedQuestions = Question::find(1);

   $user->like($mostLikedQuestions);
   $secondUser->unlike($mostUnlikedQuestions);

   \Pest\Laravel\withoutExceptionHandling();

    actingAs($user);
    get(route('dashboard', $questions))
    ->assertViewHas('questions', function ($questions)  {

        expect($questions)
            ->first()->id
            ->toBe(3)
        ->and($questions)
        ->last()->id()->toBe(1);

        return true;





    });


});
