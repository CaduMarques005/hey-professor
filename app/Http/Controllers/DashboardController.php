<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {

        return view('dashboard', [
            'questions' => Question::withSum('votes', 'like')
                ->withSum('votes', 'unlike')
                ->orderByRaw('if(votes_sum_like is null, 0, votes_sum_like) desc,
                if(votes_sum_unlike is null, 0, votes_sum_unlike)')
                ->paginate(5),
        ]);

    }
}
