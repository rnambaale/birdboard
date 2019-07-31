@extends('layouts.app')

@section('content')
<div class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 md:px-16 rounded shadow">        
    <h1 class="text-2xl font-normal mb-10 text-center">Edit your Project</h1>
    <form method="POST" action="{{ $project->path() }}">
        @method('PATCH')

        @include('projects._form')

        <div>
            <button type="submit" class="btn btn-blue">Update</button>
            <a href="{{ $project->path() }}">Cancel</a>
        </div>
    </form>
</div>
@endsection