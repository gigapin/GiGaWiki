<x-app-layout>
    <div class="w-11/12 mx-auto bg-white px-2 lg:w-6/12 lg:col-start-1 lg:col-end-5 rounded-md">
        <p class="text-xl font-bold py-2">Tag</p>
        @foreach($projects as $url => $project)

            @isset($project->title)
                @if($url === 'page')
                <div class="flex justify-between border-b border-gray-200">
                    <div class="pt-3">
                        <i class="bi bi-file-arrow-up mr-1"></i>
                        <a href="{{ route($url . 's.show', $project->slug) }}">{{ $project->title }}</a>  
                    </div>
                </div>
                @endif
            @endisset

            @isset($project->name)
                <div class="flex justify-between border-b border-gray-200">
                    <div class="pt-3">
                        <i class="bi bi-file-arrow-up mr-1"></i>
                        <a href="{{ route($url . 's.show', $project->slug) }}">{{ $project->name }}</a>  
                    </div>
                </div>
            @endisset

        @endforeach
    </div>
</x-app-layout>
