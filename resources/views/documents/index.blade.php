<x-document-layout>

    @include('partials.sidebar')

    <section class="md:flex-grow bg-gray-50 py-4 px-6" id="doc-section">
        {{-- md:col-span-2 md:row-span-2 --}}
        <div class="">
            <div class="h-auto">
                @if($description)
                    <h2>{{ $project->name }}</h2>
                    {!! $project->description !!}
                @else
                    @if (session()->has('warning'))
                        <x-alert :type="'warning'" message="{{ session('warning') }}" />
                    @endif
                    <h2>{{ $doc->title }}</h2>
                    {!! $doc->content !!}
                @endif  
                
            </div>
            @include('partials.footer')
        </div>
    </section>

</x-document-layout>