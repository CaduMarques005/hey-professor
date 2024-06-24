<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Question\LikeController;
use App\Http\Controllers\Question\PublishController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UnlikeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
    Route::patch('/question/{question}/archive', [QuestionController::class, 'archive'])->name('question.archive');
    Route::patch('/question/{question}/restore', [QuestionController::class, 'restore'])->name('question.restore');
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

// OAuth routes
Route::get('github/auth/login', function () {

    return Socialite::driver('github')->redirect();
})->name('github.login');

Route::get('github/auth/callback', function () {

    $githubUser = Socialite::driver('github')->user();

    $user = User::query()
        ->updateOrCreate([
            'email' => $githubUser->email,
            'name' => $githubUser->name,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password' => Hash::make('password'),
        ]);

    Auth::login($user);

    return to_route('dashboard');
});

require __DIR__.'/auth.php';
