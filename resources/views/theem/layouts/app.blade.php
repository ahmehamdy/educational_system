<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('theem.shared.head')
</head>
<body>
    @include('theem.shared.header')
    {{-- @include('theem.shared.aside') --}}


@yield('content')


    @include('theem.shared.script')

</body>
</html>
