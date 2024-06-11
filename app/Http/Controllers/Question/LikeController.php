<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\{User, Question};
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Question $question): RedirectResponse
    {

        auth()->user()->like($question);


        return back();
    }
}
