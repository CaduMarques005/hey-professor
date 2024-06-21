<?php

it('should prune records deleted more than 1 month', function() {

    $question = \App\Models\Question::factory()->create(['deleted_at' => \Carbon\Carbon::now()->subMonth(2)]);

    \Pest\Laravel\artisan('model:prune');

    \Pest\Laravel\assertDatabaseMissing('questions', ['id' => $question->id]);
});
