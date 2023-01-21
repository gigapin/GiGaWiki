<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('font/icons/font/bootstrap-icons.css') }}">

    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('summernote/summernote/summernote-lite.min.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/editor.css') }}">

</head>

<body class="font-sans leading-normal tracking-normal" id="main">

    @include('partials.navbar')

    <div class="flex justify-around bg-gray-500 mt-0 mb-4 pt-20 pb-4 text-gray-200 border-t-2 border-b-2 border-gray-800 xl:hidden">
        <div class="w-1/2 text-center border-r-2 border-gray-800">
            <button onclick="sxFunc()" class="hover:text-white">Info</button>
        </div>
        <div class="w-1/2 text-center border-l-2 border-gray-800">
            <button onclick="dxFunc()" class="hover:text-white">Content</button>
        </div>
    </div>

    <div class="py-20 xl:grid xl:grid-cols-4 xl:grid-rows-7 xl:gap:2 2xl:gap-0 2xl:flex">
        {{ $slot }}
    </div>

    <!-- ################################### -->
    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('summernote/summernote/summernote-lite.min.js') }}"></script>

    <script>
        var node = document.createElement('div');
        $('#post').summernote('insertNode', node, {
            tabsize: 2,
            height: 440,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        $('#note').summernote({
            tabsize: 2,
            height: 220,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

    </script>

</body>

</html>
