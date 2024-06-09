<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\post;
use App\Models\User;
use App\Models\Question;
use function Pest\Laravel\actingAs;


it('should be able to like a question', function() {

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
