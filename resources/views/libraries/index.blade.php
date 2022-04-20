<x-app-layout>
    <x-toolbar :title="$title" :link="$link" />

    <div class="container">
        @if(count($bodies) < 1)
            @include('partials.unvailable')
        @else
            <x-alert type="success" message="{{ session()->get('success') }}" />
            <x-table :heads="$heads" :bodies="$bodies" :url="$title" />
            {{ $bodies->links() }}
        @endif
    </div>
</x-app-layout>
