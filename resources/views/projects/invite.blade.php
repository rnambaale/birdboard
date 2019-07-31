<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl mb-6 py-4 border-l-4 border-blue-500 pl-4">
        Invite a User
    </h3>

    <form method="POST" action="{{ $project->path().'/invitations' }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" placeholder="Email address" class="border border-gray-400 rounded w-full py-2 px-3"/>
        </div>
        <button type="submit" class="btn btn-blue text-xs">Invite</button>
    </form>
</div>
@include('errors', ['bag' => 'invitations'])