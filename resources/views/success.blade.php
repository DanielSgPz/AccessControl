<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <div class="flex h-screen items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg  max-w-sm ">
            <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">Authentication ROOM 911</h2>
            <h3>Access OK</h3>
        </div>
    </div>

</body>

</html>
