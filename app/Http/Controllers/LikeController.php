<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
