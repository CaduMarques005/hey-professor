<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UnlikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function unlike(Question $question): RedirectResponse
    {
        auth()->user()->unlike($question);
        return back();
    }
}
