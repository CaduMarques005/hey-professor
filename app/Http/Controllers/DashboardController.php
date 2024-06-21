<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {

        return view('dashboard', [
            'questions' => Question::query()
            ->when(request()->has('search'), function (Builder $query) {
                $query->where('question', 'like', '%' . request('search') . '%');
            })
            ->withSum('votes', 'like')
                ->withSum('votes', 'unlike')
                ->orderByRaw('if(votes_sum_like is null, 0, votes_sum_like) desc,
                if(votes_sum_unlike is null, 0, votes_sum_unlike)')
                ->paginate(5),
        ]);

    }
}
