<?php

namespace App\Http\Middleware;

use Closure;
use App\Project;

class OwnerCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $guard = null)
     {
         if (\Auth::guard($guard)->check()) {

             // 라우트에서 현재 프로젝트 id 추출
             $pid = \Route::current()->getParameter('project');
             if (isset($pid)) {
                 $project = Project::find($pid);

                 $user = \Auth::user();
                 if ($project->user->id != $user->id) {
                     \Log::error('잘못된 프로젝트 접근 시도: ', [
                         'user-id' => $user->id,
                         'name'=> $user->name,
                         'project-id' => $project->id,
                     ]);

                     return redirect('/home')
                         ->with('message', '인증 실패: 소유한 프로젝트만 접근 가능합니다.');
                 }
             }
         }

         return $next($request);
     }
}
