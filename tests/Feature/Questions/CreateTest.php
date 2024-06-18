<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Executar migrações antes de cada teste
    $this->artisan('migrate');
});

it('should be able to create a new question bigger than 255 characters', function () {
    // Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act :: agir
    $response = $this->post(route('question.store'), [
        'question' => str_repeat('*', 260).'?',
    ]);

    // Assert :: verificar
    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseCount('questions', 1);
    $this->assertDatabaseHas('questions', ['question' => str_repeat('*', 260).'?']);
});

it('should create as a draft all the time', function () {

    $user = User::factory()->create();
    actingAs($user);

    // ACT :: Agir
    $response = $this->post(route('question.store'), [
        'question' => str_repeat('*', 260).'?',
        'draft' => true,
    ]);

    // Assert :: Verificar
    $this->assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260).'?',
        'draft' => true,
    ]);
});

it('should check if ends with question marks ?', function () {

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
