<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function vote(Question $question, Request $request){
    	$vote = (int) Request()->vote;
    	auth()->user()->voteQuestion($question, $vote);  
    	return back();
    }
}
