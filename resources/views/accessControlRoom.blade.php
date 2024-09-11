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
            <form action="/access" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="id" class="block text-sm font-medium text-gray-700">Enter ID</label>
                    <input type="number" name="id" id="id" required
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Enter
                </button>
            </form>
        </div>
    </div>

</body>

</html>
