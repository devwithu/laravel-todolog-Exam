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
        // 현재 캐시 드라이버 설정 확인
        $drv = \Config::get('cache.default');

        if ($drv === 'redis') { // redis 일 경우
            $userCount = Redis::get('user:count');
            $projectCount= Redis::get('project:count');
            $taskCount= Redis::get('task:count');
        } else {        // 아닐 경우 DB 에서 읽어 옴.
            $userCount = User::count();
            $projectCount = Project::count();
            $taskCount = Task::count();
        }

        $total = [ 'user' => $uc,
            'project' => $pc,
            'task' => $tc,
        ];
        return view('welcome')->with('total', $total);
    }
}
