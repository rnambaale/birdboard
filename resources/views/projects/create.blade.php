@extends('layouts.app')

@section('content')
<div class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 md:px-16 rounded shadow">        
    <h1 class="text-2xl font-normal mb-10 text-center">Create Project</h1>
    <form method="POST" action="/projects">
        @include('projects._form', ['project' => new App\Project])
        <div>
            <button type="submit" class="btn btn-blue">Submit</button>
            <a href="/projects">Cancel</a>
        </div>
    </form>
</div>
@endsection