<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

class ProjectTasksController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);


        $request->validate([ 'body'   => ['required'] ]);

        $project->addTask($request['body']);

        return redirect($project->path());
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, Project $project, Task $task)
    {
        $this->authorize('update', $project);

        $request->validate([ 'body'   => ['required'] ]);

        $task->update([
            'body'      => $request['body'],
        ]);

        $request['completed'] ? $task->complete() : $task->incomplete();

        return redirect($project->path());
    }

    
    public function destroy(Project $project, Task $task)
    {
        $task->delete();
        return redirect($project->path());
    }
}
