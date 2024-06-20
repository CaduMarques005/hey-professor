<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Question\LikeController;
use App\Http\Controllers\Question\PublishController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UnlikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->isLocal()) {
        auth()->loginUsingId(1);

        return to_route('dashboard');
    }

    return view('login');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //Region question Routes


    Route::get('/question', [QuestionController::class, 'index'])->name('question.index');
    Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/question/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    Route::put('/question/{question}', [QuestionController::class, 'update'])->name('question.update');
    Route::delete('/question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
    Route::patch('/question/{question}', [QuestionController::class, 'archive'])->name('question.archive');
    Route::post('/question/vote', [LikeController::class])->name('');
    Route::post('/question/like/{question}', [LikeController::class, 'like'])->name('question.like');
    Route::post('/question/unlike/{question}', [UnlikeController::class, 'unlike'])->name('question.unlike');
    Route::put('/question/publish/{question}', [PublishController::class, 'publish'])->name('question.publish');

    //EndRegion

    //Region Profile Routes

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //endRegion
});

Route::middleware('auth')->group(function () {

});

require __DIR__.'/auth.php';
