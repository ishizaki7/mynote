<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
  
   public function index()
  {    
       $date = [];
       if (\Auth::check()) {
       $user =  \Auth::user();
       $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(25);
       
       $data = [
           'user'=> $user,
           'tasks'=> $tasks,
       ];
       
     return view('tasks.index', $data);
       }
    else {
    return view('welcome');
    }   

     
  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create',[
            'task'=>$task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
             'status' => 'required|max:10', 
            'content' => 'required|max:191',
        ]);
        $task = new Task;
        $task->user_id = \Auth::user()->id;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = \App\Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
            'task' => $task,
        ]);
        }
        else {
        return redirect('/');
         }   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = \App\Task::find($id);
        
       if (\Auth::id() === $task->user_id) {
        return view('tasks.edit', [
            'task' => $task,
        ]);
       }
        else {
        return view('/');
         }   
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
        $task = \App\Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
        $this->validate($request, [
            'status' => 'required|max:10', 
            'content' => 'required|max:191',
        ]);
        
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = \App\Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        
        return redirect('/');
    }
     
    }
}
    