<x-document-layout>

    @include('partials.sidebar')

    <section class="md:flex-grow bg-gray-50 py-4 px-6" id="doc-section"> 
        {{-- md:col-span-2 md:row-span-2 --}}
        <div class="">
            <div class="h-auto">
                @if (session()->has('warning'))
                <x-alert :type="'warning'" message="{{ session('warning') }}" />
                @endif
                <h2>{{ $doc->title }}</h2>
                {!! $doc->content !!}
    
            </div>
            
            @include('partials.footer')
            
        </div>
        

    </section>
    
    
    
</x-document-layout>