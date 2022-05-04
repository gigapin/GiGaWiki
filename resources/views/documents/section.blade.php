<x-document-layout>

    @include('partials.sidebar')

    <section class="md:col-span-2 md:row-span-2 bg-gray-50 py-4 px-6" id="doc-section">  
        <h2>{{ $sec->title }}</h2>
        {!! $sec->description !!}
    </section>

    @include('partials.footer')

</x-document-layout>