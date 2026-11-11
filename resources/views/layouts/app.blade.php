<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'UMKM Kita')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/styleheader.css', 'resources/css/stylefooter.css', 'resources/css/stylehome.css', 'resources/js/home.js', 'resources/js/home.js', 
    'resources/js/app.js'])
</head>
<body>

    @include('partials.header')

    @yield('content')
    
    @include('partials.footer')
</body>
</html>