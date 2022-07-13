<x-document-layout>

    @include('partials.sidebar')

    <section class="md:col-span-2 md:row-span-2 bg-gray-50 py-4 px-6" id="doc-section">  
        <div class="">
            <div class="h-auto">
                <h2>{{ $sec->title }}</h2>
                {!! $sec->description !!}
            </div>
            @include('partials.footer')
        </div>
    </section>

</x-document-layout>