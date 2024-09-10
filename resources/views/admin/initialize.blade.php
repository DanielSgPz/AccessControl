<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4 flex justify-center">Admins Management</h1>



        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabla de Administradores -->
        <div class="mt-8 bg-white p-4 rounded-md shadow-md">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-bold">Users Admins</h2>
                <div class="flex justify-end">
                    <!-- Modal toggle -->
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Create new admin
                    </button>
                </div>
            </div>

            <table class="min-w-full divide-y divide-gray-200 bg-white rounded-md shadow-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Last Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if ($admins)
                        @foreach ($admins as $admin)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $admin->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $admin->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $admin->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $admin->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button data-id="{{ $admin->id }}" class="edit-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">Edit</button>
                                    {{-- <button data-id="{{ $admin->id }}" class="edit-btn block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 ">Delete</button> --}}

                                    <form action="{{ route('admin.delete', $admin->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este administrador?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700">Delete</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>


    </div>


    <!-- Main modal -->
    {{--  <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="flex hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Admin
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" action={{ route('initialize.submit') }} method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2sm:col-span-1">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Name" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="last_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last name</label>
                            <input type="text" name="last_name" id="last_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Last name" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Email" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="text" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Password" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                                Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Confirm Password" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                                Status</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="radio" name="status" value="active"
                                        class="bg-gray-50 border border-gray-300 text-primary-500 focus:ring-primary-500 focus:border-primary-500 rounded-full dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <span class="ml-2">Active</span>
                                </label>
                                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="radio" name="status" value="inactive"
                                        class="bg-gray-50 border border-gray-300 text-primary-500 focus:ring-primary-500 focus:border-primary-500 rounded-full dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <span class="ml-2">Inactive</span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Add new admin
                    </button>
                </form>
            </div>
        </div>
    </div> --}}

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="flex hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative  w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">Register Admin</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="crud-form" method="POST" action="{{ route('initialize') }}">
                    @csrf
                    <input type="hidden" name="id" id="admin-id">
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Name" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="last_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last name</label>
                            <input type="text" name="last_name" id="last_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Last name" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Email" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="text" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Password">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                                Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Confirm Password" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User Status</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="radio" name="status" value="active"
                                        class="bg-gray-50 border border-gray-300 text-primary-500 focus:ring-primary-500 focus:border-primary-500 rounded-full dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <span class="ml-2">Active</span>
                                </label>
                                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="radio" name="status" value="inactive"
                                        class="bg-gray-50 border border-gray-300 text-primary-500 focus:ring-primary-500 focus:border-primary-500 rounded-full dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <span class="ml-2">Inactive</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <span id="form-button-text">Register</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                fetch(`/admin/edit/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('admin-id').value = data.id;
                        document.getElementById('name').value = data.name;
                        document.getElementById('last_name').value = data.last_name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('password').value = '';
                        document.querySelector(`input[name="status"][value="${data.status}"]`).checked =
                            true;
                        document.getElementById('modal-title').textContent = 'Edit Admin';
                        document.getElementById('form-button-text').textContent = 'Update';
                        document.getElementById('crud-form').action = `/admin/update/${data.id}`;
                        document.getElementById('form-method').value = 'PUT';
                        document.getElementById('crud-modal').classList.remove('hidden');
                    });
            });
        });

        $(document).ready(function() {
            // Open modal
            $('[data-modal-toggle="crud-modal"]').on('click', function() {
                $('#crud-modal').removeClass('hidden');
                console.log("Modal opened");
            });

            // Close modal
            $('#crud-modal button[data-modal-toggle="crud-modal"]').on('click', function() {
                $('#crud-modal').addClass('hidden');
                console.log("Modal closed");
            });

            // Close modal
            $(window).on('click', function(e) {
                if ($(e.target).is('#crud-modal')) {
                    $('#crud-modal').addClass('hidden');
                }
            });
        });
    </script>

</body>

</html>
