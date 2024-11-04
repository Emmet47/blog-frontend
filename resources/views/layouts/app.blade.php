<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Laravel Frontend')</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
    @stack('styles')
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    @include('components.navbar')




    <!-- Content -->
    <div class="container mx-auto py-6">
        @yield('content')
    </div>


    <!-- Footer -->
    @include('components.footer')

    @livewireScripts
    @stack('scripts')
</body>

</html>
