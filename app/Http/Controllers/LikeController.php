<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {
        /* @var User $user*/

        $user = Auth::user();
        user()->like($question);

        return back();
    }
}
