<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;

class PublishController extends Controller
{
    public function publish(Question $question): RedirectResponse
    {
        $this->authorize('publish', $question);

        $question->update(['draft' => false]);

        return back();
    }
}
