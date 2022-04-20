<x-app-layout>
    <div class="w-11/12 mx-auto bg-white p-2 lg:w-8/12 lg:col-start-1 lg:col-end-5 rounded-md lg:p-4">
        <p class="text-xl font-bold py-2">Page Revisions</p>

        <x-link-button link="{{ route('pages.show', $slug->slug) }}" :label="'Back'" class="mb-2" />
        
        @foreach($revisions as $row)
        <div class="flex justify-between border-b border-gray-200 py-2">
            <div>
                <i class="bi bi-file-code mini-icons"></i>
                {{ $row->title }}
            </div>
            <div>
                <i class="bi bi-person mini-icons"></i>
                {{ $user->name }}
            </div>
            <div>
                <i class="bi bi-alarm mini-icons"></i>
                {{ $row->updated_at }}
            </div>
            <div> 
                <div class="flex flex-row">
                    <div>  
                        <a href="{{ route('revisions.preview', [$row->project->slug, $row->page_id, $row->id]) }}">Preview</a>
                    </div>
                    <div class="mx-4">
                        <a href="{{ route('revisions.restore', [$row->project->slug, $row->page_id, $row->id]) }}">Restore</a>
                    </div>
                    <div>
                        <form action="{{ route('revisions.delete', [$row->project->slug, $row->page_id, $row->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</x-app-layout>
