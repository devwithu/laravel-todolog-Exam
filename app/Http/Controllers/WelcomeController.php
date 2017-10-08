<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;
use App\Task;
use App\User;

class WelcomeController extends Controller
{
    /**
    * 사이트 웰컴 화면
    *
    * @return \Illuminate\Http\Response
    */
    public function index()  //2
    {
        $uc = User::count();
        $pc = Project::count();
        $tc = Task::count();

        $total = [ 'user' => $uc,
            'project' => $pc,
            'task' => $tc,
        ];
        return view('welcome')->with('total', $total);
    }
}
