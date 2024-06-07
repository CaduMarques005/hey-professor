<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {


       return view('dashboard', [
           'questions' => Question::all(),
       ]);


    }
}
