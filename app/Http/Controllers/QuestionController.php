<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\SameQuestionRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index()
    {
        return view('question.index', [
            'questions' => user()->questions,
            'archivedQuestions' => user()->questions()->onlyTrashed()->get(),
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
            new SameQuestionRule(),
        ]);


        user()->questions();
        Question::query()->create([
            'question' => request()->question,
            'draft' => true,
            'created_by' => auth()->id(),
        ]);

        return back();

    }

    public function edit(Question $question): View
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question')); // mesma coisa que ['question' => $question]
    }

    public function update(Question $question)
    {
        $this->authorize('update', $question);
        $question->question = request()->question;
        $question->save();

        return to_route('question.index');
    }

    public function archive(Question $question)
    {
        $this->authorize('archive', $question);
        $question->delete();

        return back();
    }

    public function restore(int $id)
    {
        $question = Question::withTrashed()->find($id);

        $this->authorize('restore', $question);

        $question->restore();

        return back();
    }

    public function destroy($id)
    {
        $question = Question::withTrashed()->find($id);
        $this->authorize('destroy', $question);

        $question->forceDelete();

        return back();
    }
}
