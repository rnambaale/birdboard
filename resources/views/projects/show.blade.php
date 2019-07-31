@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex items-end justify-between w-full">
            <p class="text-gray-500 text-sm font-normal">
                <a href="/projects" class="text-gray-500 text-sm font-normal no-underline">My Projects</a> / {{ $project->title }}
            </p>

            <div class="flex items-center">

                @foreach ($project->members as $member)
                    <img
                        src="{{ gravatar_url($member->email) }}"
                        alt="{{ $member->name }}'s avatar'"
                        class="rounded-full w-8 mr-2" />
                @endforeach

                <img
                    src="{{ gravatar_url($project->owner->email) }}"
                    alt="{{ $project->owner->name }}'s avatar'"
                    class="rounded-full w-8 mr-2" />

                <a href="{{ $project->path().'/edit' }}" class="btn btn-blue ml-4">Edit project</a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3">
                <div class="mb-6">
                    <h2 class="text-lg text-gray-500 font-normal mb-3">Tasks</h2>

                    @foreach ($project->tasks as $task)
                    <div class="card mb-3">
                        <form method="POST" action="{{ $task->path() }}">
                            @csrf
                            @method('PATCH')
                            <div class="flex">
                                <input type="" name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-500' :'' }}" required>
                                <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' :'' }} >
                            </div>
                        </form>
                    </div>
                    @endforeach

                    <form method="POST" action="{{ $project->path().'/tasks' }}">
                        @csrf
                        <input type="" name="body" class="w-full" placeholder="Begin adding tasks..." required>
                    </form>

                </div>


                <div>
                <h2 class="text-lg text-gray-500 font-normal mb-4">General Notes</h2>

                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')
                        <textarea name="notes" class="card w-full" style="min-height: 200px;">{{ $project->notes }}</textarea>
                        <button type="submit" class="btn btn-blue">Save</button>
                    </form>

                    @include('errors')
                </div>

            </div>
            <div class="lg:w-1/4 px-3">
                <div class="card">
                    @include('projects.card')
                    <div>
                        <a href="/projects">Go Back</a>
                    </div>
                </div>

                @include('projects.activity.card')

                @can('manage', $project)
                    @include('projects.invite')
                @endcan
            </div>
        </div>
        
    </main>
@endsection