<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;
use App\Task;

class ProjectTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index($project)
     {
         $proj = Project::findOrFail($project);

         $tasks = $proj->tasks()->get();

         return view('project.task.index')
                 ->with('tasks', $tasks)
                 ->with('proj', $proj);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create($projId)
     {
         $proj = Project::findOrFail($projId);

         return view('project.task.create')
             ->with('proj', $proj);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(StoreTaskRequest $request, $projId)
     {
/*
         $this->validate($request, [
             'name' => 'required|unique:tasks|max:20',
             'proority' => 'in:낮음,보통,높음',
             'due_date' => 'date|after:today',
         ]);
*/
         $task = new Task([    //1
             'name' => $request->get('name'),
             'description' => $request->get('description'),
             'priority' => $request->get('priority'),
             'status' => $request->get('status'),
             'due_date' => $request->get('due_date'),
         ]);

         $task->project()->associate($projId);;    //2

         $task->save();    //3

         return redirect(route('project.task.index', $task->project->id))
             ->with('message', $task->name . ' 가 생성 되었습니다.');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($projId, $taskId)
     {
         $user = \Auth::user();
         $projects = $user->projects()->get();

         $task = Task::findOrFail($taskId);

         if($task->project->id != $projId) {
             abort(403, '잘못된 접근입니다.');
         }

         return view('project.task.edit')
             ->with('projects', $projects)
             ->with('task', $task);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $projId, $taskId)
     {
         $task = Task::findOrFail($taskId);

         $project_id = $request->get('project_id');

         // project id를 변경할 경우
         if ($project_id != $task->project->id) {
             // 변경된 project 검색
             $project = Project::findOrFail($project_id);
             $task->project()->associate($project);
         }

         $task->update([        // 2
             'name' => $request->get('name'),
             'description' => $request->get('description'),
             'priority' => $request->get('priority'),
             'status' => $request->get('status'),
             'due_date' => $request->get('due_date'),
         ]);

         return redirect(route('project.task.index', $task->project->id))
             ->with('message', $task->name . '가 수정되었습니다.');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
