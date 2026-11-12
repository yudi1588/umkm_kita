<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'UMKM Kita')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png"href="{{ asset('assets/user/img/logoumkm.png') }}">
    @vite(['resources/css/styleheader.css', 'resources/css/stylefooter.css', 'resources/css/stylehome.css', 'resources/js/home.js', 'resources/js/home.js', 
    'resources/js/statistik.js', 'resources/css/stylestatistik.css','resources/js/app.js' , 'resources/css/checkout.css'])
</head>
<body>

    @include('partials.header')

    @yield('content')
    
    @include('partials.footer')

    
 </script>
    @vite('resources/js/keranjang.js')


</body>
</html>