<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access Control V1.0</title>
    @vite('resources/css/app.css')
    <style>
         body {
            background-image: url('{{asset('media/imges/secuirty.jpg')}}');
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-xl font-bold">Access Control</div>
            <div>
                @auth
                    <!-- User is authenticated -->
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="hover:text-gray-400">Logout</button>
                    </form>
                @else
                    <!-- User is not authenticated -->
                    <a href="{{ route('login') }}" class="hover:text-gray-400">Login</a>
                @endauth
            </div>
        </div>
    </div>

</body>

</html>
