<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $user = \Auth::user();

         // 시작일 설정
         if(!empty($request->get('start_date'))) {
             $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('start_date'));
         } else {
             $start_date = Carbon::now();
         }

         // 종료일 설정
         if(!empty($request->get('end_date'))) {        //2
             $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('end_date'));
         } else {
             $end_date = $start_date->copy()->addMonths(1);
         }

         $tasks = $user->tasks()
             ->dueDateBetween($start_date, $end_date)        // 쿼리 스코프
             ->otherParam($request)                        // 나머지 검색 조건
             ->orderBy('due_date', 'desc')
             ->get();

         return view('task.index')
             ->with('tasks', $tasks)
             ->with('start_date', $start_date)
             ->with('end_date', $end_date)
             ->with('status', $request->get('status'))
             ->with('priority', $request->get('priority'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
