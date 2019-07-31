<div class="card mt-3">
    <ul class="text-xs list-reset">
    @foreach ($project->activity as $activity)
        <li>
            @include("projects.activity.{$activity->description}")
            <span class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
        </li>
    @endforeach
    </ul>
</div>