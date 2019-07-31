
@csrf

<div class="field mb-6">
    <label class="label text-sm mb-2 block">Title</label>
    <div class="control">
        <input
            type="text"
            name="title"
            class="bg-white focus:outline-0 focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal"
            value="{{ $project->title }}"/>
    </div>
</div>
<div class="field mb-6">
    <label class="label text-sm mb-2 block">Description</label>
    <div class="control">
        <textarea
            name="description"
            class="bg-white focus:outline-0 focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal"
        >{{ $project->description }}</textarea>
    </div>
</div>
        