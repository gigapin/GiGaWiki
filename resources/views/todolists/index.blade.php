<x-app-layout>

	<x-actions-bar>

	</x-actions-bar>

	<x-create-form :model="'ToDoList'">

		@if (session()->has('success'))
		<x-alert :type="'success'" message="{{ session('success') }}" />
		@endif

		@if(count($todolists) < 1) @include('partials.unvailable') @else <div class="md:grid md:grid-cols-2 md:gap-2 2xl:grid 2xl:grid-cols-3">
			@foreach($todolists as $item)
			<x-cards title="{{ $item->title }}" body="{{ $item->description }}" slug="{{ $item->slug }}" :model="'todolists'" />
			@endforeach
			</div>
			@endif

	</x-create-form>

	<div class="absolute top-36 mt-1 ml-2 w-full z-0 md:w-8/12 lg:mt-0 lg:static lg:block lg:row-start-1 lg:row-end-1 lg:ml-4 2xl:ml-0 lg:mb-4 2xl:w-80" id="last-box">
		<div class="p-2 w-6/12 lg:w-full lg:mx-auto lg:p-2 lg:ml-0 2xl:w-8/12 2xl:mx-auto text-base lg:text-lg">
			<a href="javscript:void" id="">
				<i class="bi bi-plus-square icons"></i>
				Add Task
			</a>
		</div>
	</div>

</x-app-layout>