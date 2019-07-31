@extends('layouts.app')


@section('content')    

    <header class="flex items-center mb-3 py-4">
        <div class="flex items-end justify-between w-full">
            <h2 class="text-gray-500 text-sm font-normal">My Projects</h2>
            <a href="/projects/create" class="btn btn-blue">Create project</a>
        </div>
    </header>

    <main class="flex flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty

            <div>No Project yet</div>
            
        @endforelse
    </main>

@endsection