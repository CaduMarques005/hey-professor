<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{

    public function index()
    {
        return view('question.index', [
            'questions' => user()->questions
            ]);
    }
    public function store(\Illuminate\Http\Request $request): RedirectResponse
    {

        $request->validate([
            'question' => ['required', 'min:10', function (string $attribute, mixed $value, \Closure $fail) {
                if ($value[strlen($value) - 1] != '?') {
                    $fail('Are you sure that is a question? It is missing the question mark in the end');
                }
            }],
        ]);
        user()->questions();
        Question::query()->create([
            'question' => request()->question,
            'draft' => true,
            'created_by' => auth()->id(),
        ]);

        return back();

    }
}
