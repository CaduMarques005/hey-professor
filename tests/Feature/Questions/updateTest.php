<?php
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use App\Models\Question;
use App\Models\User;
use function Pest\Laravel\put;

it('should be able to update a question', function () {
    $user = User::factory()->create();

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question),[
        'question' => 'updated question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)
        ->question->toBe('updated question?');
});
