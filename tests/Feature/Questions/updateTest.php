<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('should be able to update a question', function () {
    $user = User::factory()->create();

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'updated question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)
        ->question->toBe('updated question?');
});

it('should make sure that only the person who has created a question can edit the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question = Question::factory()->create(['draft' => false, 'created_by' => $rightUser->id]);
    actingAs($wrongUser);

    get(route('question.edit', $question))
        ->assertForbidden()();

    actingAs($rightUser);

    get(route('question.edit', $question))
        ->assertSucessful();

});

it('should update the question in the database', function () {

    $user = User::factory()->create();

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'updated question?',
    ])->assertRedirect(route('question.index'));

    $question->refresh();

    expect($question)
        ->question->toBe('updated question?');
});

it('should make sure that only question with status DRAFT can be updated', function () {
    $user = User::factory()->create();

    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $draftQuestion = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.edit', $questionNotDraft))->assertForbidden();
    put(route('question.edit', $draftQuestion), ['question' => 'New Question'])->assertRedirect();
});

it('should make sure that only the person who has created the question can update the question', function () {

    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question = Question::factory()->create(['draft' => false, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    put(route('question.update', $question))->assertForbidden();

    actingAs($rightUser);
    put(route('question.update', $question), ['question' => 'New Question'])->assertRedirect();
});

it('should be able to update a new question bigger than 255 characters', function () {
    // Arrange :: preparar
    $user = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    actingAs($user);

    // Act :: agir
    $response = $this->put(route('question.update', $question), [
        'question' => str_repeat('*', 260).'?',
    ]);

    // Assert :: verificar
    $response->assertRedirect();
    $this->assertDatabaseCount('questions', 1);
    $this->assertDatabaseHas('questions', ['question' => str_repeat('*', 260).'?']);
});

it('should have at least 10 characters', closure: function () {
    // Arrange :: preparar

    $user = User::factory()->create();
    actingAs($user);

    // Act :: agir
    $response = $this->post(route('question.store'), [
        'question' => str_repeat('*', 8).'?',
    ]);

    // Assert :: verificar
    $response->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    $this->assertDatabaseCount('questions', 0);
});

test('only authenticated users can create a new question', function () {
    post(route('question.store'), [
        'question' => str_repeat('*', 8).'?',
    ])->assertRedirect('login');
});
