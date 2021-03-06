<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- start: Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- start: Icons -->
    <!-- start: CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <!-- end: CSS -->

    @yield('upper_links')

    <title>Rental Mobil</title>
</head>

<body>

    @include('partials.sidebar')

    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            
            @include('partials.navbar')
            @yield('content')
            
        </div>
    </main>
    <!-- end: Main -->

    @yield('bottom_links')



</body>



</html>