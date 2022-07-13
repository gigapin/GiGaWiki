<div class="mx-2 lg:mx-0 lg:cols-span-2 lg:col-start-2 lg:col-end-5 lg:row-span-4 2xl:flex-grow" id="main-box">
    <div class="bg-white shadow-1xl p-4 rounded lg:mr-4 2xl:mr-0 mx-auto">
        @if($model !== '')
            <p class="text-center text-2xl md:text-3xl xl:font-bold xl:py-2">{{ $model }}</p>
        @endif
        {{ $slot }}
    </div>
</div>
