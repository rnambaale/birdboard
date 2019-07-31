<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    
    public function index()
    {
        //$projects = Project::all();
        //$projects = auth()->user()->projects()->orderBy('updated_at', 'desc')->get();
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    
    public function store(Request $request)
    {
        //validate
        $attributes = $request->validate(
            [
                'title'         => 'required',
                'description'   => 'required',
                'notes'   => 'min:3',
            ]
        );

        $attributes['owner_id'] = auth()->id();

        // persist
        $project = Project::create($attributes);

        //redirect
        return redirect('projects');
    }

    
    public function show(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.show', compact('project'));
    }

    
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $attributes = $request->validate(
            [
                'title'         => 'sometimes|required',
                'description'   => 'sometimes|required',
                'notes'   => 'min:3',
            ]
        );

        $project->update($attributes);

        return redirect($project->path());
    }

    
    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }
}
