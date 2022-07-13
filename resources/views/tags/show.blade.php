<x-app-layout>
    <div class="w-11/12 mx-auto bg-white px-2 lg:w-6/12 lg:col-start-1 lg:col-end-5 rounded-md">
        <p class="text-xl font-bold py-2">Tag</p>
        @foreach ($tags as $tag)
            @foreach($projects as $project)
                @if($project->id === $tag->page_id)

                    @if($tag->page_type === 'page')
                        <div class="flex justify-between border-b border-gray-200">
                            <div class="pt-3">
                                <i class="bi bi-file-arrow-up mr-1"></i>
                                <a href="{{ route($tag->page_type . 's.show', $project->slug) }}">{{ $project->title }}</a>  
                            </div>
                            <form action="{{ route('tags.delete', $tag->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white p-1 my-2 float-right">Delete</button>
                            </form>
                        </div>
                    @else
                        <div class="flex justify-between border-b border-gray-200">
                            <div class="pt-3">
                                <i class="bi bi-file-arrow-up mr-1"></i>
                                <a href="{{ route($tag->page_type . 's.show', $project->slug) }}">{{ $project->name }}</a>        
                            </div>
                            <form action="{{ route('tags.delete', $tag->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white p-1 my-2 float-right">Delete</button>
                            </form>
                        </div>
                    @endif
                    
                @endif
            @endforeach
        @endforeach
    </div>
</x-app-layout>
