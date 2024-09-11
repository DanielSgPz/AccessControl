<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Acces Management</title>
    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 font-sans">
    <div class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-xl font-bold">Administrative Panel</div>
            <div>
                @auth
                    <div class="flex mt-2 gap-4 items-center">
                        <p class="text-lg">Welcome: {{ auth()->user()->name }}</p>
                        <a href="{{ route('dashboard') }}"
                            class="border hover:text-gray-900 p-2.5 rounded-md hover:bg-slate-200">Dashboard</a>

                        <!-- User is authenticated -->
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit"
                                class="border hover:text-gray-900 p-2.5 rounded-md hover:bg-slate-200">Logout</button>
                        </form>
                    </div>
                @else
                    <!-- User is not authenticated -->
                    <a href="{{ route('login') }}" class="hover:text-gray-400">Login</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-4">

        <div class="w-full">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg mt-2">
                <div class="flex justify-between">
                    <h4 class="font-bold">Employees List</h4>
                    <div class="flex gap-4 justify-between">
                        <!-- Modal Bulk load -->
                        <button data-modal-target="bulk_load-modal" data-modal-toggle="bulk_load-modal"
                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            Bulk load
                        </button>


                        <!-- Modal department -->
                        <button data-modal-target="department-modal" data-modal-toggle="department-modal"
                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            Admin department
                        </button>

                        <!-- Modal User -->
                        <button data-modal-target="employee-modal" data-modal-toggle="employee-modal"
                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            Create new employee
                        </button>
                    </div>
                </div>
                <table class=" mt-2 min-w-full divide-y divide-gray-200  border-2 bg-white rounded-md shadow-md"
                    id="table_users">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Employee Id</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Last Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Access</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($employees)
                            @foreach ($employees as $employee)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $employee->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $employee->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $employee->user->last_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $employee->department->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $employee->user->active ? 'Active' : 'Inactive' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $employee->has_access ? 'Yes' : 'No' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <button data-id="{{ $employee->id }}" id="edit_employee"
                                            class="edit-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">Edit</button>

                                        <button data-id="{{ $employee->id }}" id="delete_employee"
                                            class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700">Delete</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- Modal users -->
    <div id="employee-modal" tabindex="-1" aria-hidden="true"
        class="flex hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative  w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">Register new
                        employee
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="employee-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="create-employee-form" method="POST">
                    @csrf
                    <input type="hidden" name="employee-id" id="employee-id">
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
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Password" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                                Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Confirm Password" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="Department"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                                Department</label>

                            <select name="department_id" id="department_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                required>
                                <option value="" disabled selected>Select a department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                                Status</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="radio" name="status" value="active" id="statusActive"
                                        class="bg-gray-50 border border-gray-300 text-primary-500 focus:ring-primary-500 focus:border-primary-500 rounded-full dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <span class="ml-2">Active</span>
                                </label>
                                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="radio" name="status" value="inactive" id="statusInactive"
                                        class="bg-gray-50 border border-gray-300 text-primary-500 focus:ring-primary-500 focus:border-primary-500 rounded-full dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required>
                                    <span class="ml-2">Inactive</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="has_access"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                                Access</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="radio" name="has_access" value="1" id="accessYes"
                                        class="bg-gray-50 border border-gray-300 text-primary-500 focus:ring-primary-500 focus:border-primary-500 rounded-full dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                    <input type="radio" name="has_access" value="0" id="accessNo"
                                        class="bg-gray-50 border border-gray-300 text-primary-500 focus:ring-primary-500 focus:border-primary-500 rounded-full dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <span class="ml-2">No</span>
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

    <!-- Modal department -->
    <div id="department-modal" tabindex="-1" aria-hidden="true"
        class="flex hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative  max-h-full">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">Departments
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="department-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <table class="min-w-full divide-y divide-gray-200 bg-white rounded-md shadow-md"
                    id="table_departments">
                    <thead>
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($departments)
                            @foreach ($departments as $department)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $department->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $department->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <button data-id="{{ $department->id }}" id="edit-department"
                                            class="edit-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">Edit</button>

                                        <button data-id="{{ $department->id }}" id="delete-department"
                                            class="block text-white bg-red-400 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-66 dark:hover:bg-red-700">Delete</button>


                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <h4 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Create new department</h4>
                <form id="department-form" method="POST" action="{{ route('departments.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="department_department_id" id="department_department_id"
                        value="">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <input type="text" name="department_name" id="department_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Department name" required>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span id="form-button-text">Add department</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal bulk load -->
    <div id="bulk_load-modal" tabindex="-1" aria-hidden="true"
        class="flex hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-2 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Bulk Load
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="bulk_load-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M1 1l6 6m0 0 6 6M7 7l6-6M7 7L1 13" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="large_size">Upload CSV file</label>
                        <input
                            class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="csv_file" type="file" accept=".csv">
                    </div>

                    <!-- Table to show the preview -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 bg-white rounded-md shadow-md">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                        Last Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                        Password
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                        Department
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                        Access
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="csv-preview-body" class="bg-white divide-y divide-gray-200">
                                <!-- Preview load employees -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit button -->
                    <button id="submit-csv"
                        class="mt-4 text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Load employees
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        //Check control access for users inactive
        const statusActive = document.getElementById('statusActive');
        const statusInactive = document.getElementById('statusInactive');
        const accessYes = document.getElementById('accessYes');
        const accessNo = document.getElementById('accessNo');

        function toggleAccess() {
            if (statusInactive.checked) {
                accessYes.disabled = true;
                accessYes.checked = false;
                accessNo.checked = true;
                accessNo.disabled = true;
            } else {
                accessYes.disabled = false;
                accessNo.disabled = false;
            }
        }

        statusActive.addEventListener('change', toggleAccess);
        statusInactive.addEventListener('change', toggleAccess);

        //Modal users function
        $(document).ready(function() {
            // Open modal
            $('[data-modal-toggle="employee-modal"]').on('click', function() {
                $('#form-button-text').text('Register');
                $('#employee-modal').removeClass('hidden');
            });

            // Close modal
            $('#employee-modal button[data-modal-toggle="employee-modal"]').on('click', function() {
                $('#create-employee-form')[0].reset();
                $('#employee-modal').addClass('hidden');
            });

            // Close modal
            $(window).on('click', function(e) {
                if ($(e.target).is('#employee-modal')) {
                    $('#create-employee-form')[0].reset();
                    $('#employee-modal').addClass('hidden');
                }
            });
        });

        //Modal department function
        $(document).ready(function() {
            // Open modal
            $('[data-modal-toggle="department-modal"]').on('click', function() {
                $('#department-modal').removeClass('hidden');
            });

            // Close modal
            $('#department-modal button[data-modal-toggle="department-modal"]').on('click', function() {
                $('#department-modal').addClass('hidden');
            });

            // Close modal
            $(window).on('click', function(e) {
                if ($(e.target).is('#department-modal')) {
                    $('#department-modal').addClass('hidden');
                }
            });
        });

        //Employees management
        $(document).ready(function() {
            $('#create-employee-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('employees.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Cerrar el modal
                        $('#employee-modal').addClass('hidden');

                        // Vaciar el formulario
                        $('#create-employee-form')[0].reset();
                        updateEmployeeTable(response.employee);
                        alert(response.message);
                    },
                    error: function(response) {
                        alert('Error creating employee');
                    }
                });
            });
        });

        // Edit employee
        $(document).on('click', '#edit_employee', function() {
            var employeeId = $(this).data('id');

            $.ajax({
                url: `/employees/${employeeId}`,
                method: 'GET',
                success: function(response) {
                    $('#employee-id').val(response.employee.id);

                    $('#name').val(response.employee.user.name);
                    $('#last_name').val(response.employee.user.last_name);
                    $('#email').val(response.employee.user.email);
                    $('#department_id').val(response.employee.department_id);
                    $('input[name=status][value=' + (response.employee.user.active ? 'active' :
                        'inactive') + ']').prop('checked', true);
                    $('input[name=has_access][value=' + (response.employee.has_access ? '1' : '0') +
                        ']').prop('checked', true);

                    $('#password').removeAttr('required');
                    $('#password_confirmation').removeAttr('required');

                    // Show modal
                    $('#employee-modal').removeClass('hidden');
                    $('#form-button-text').text('Update');
                },
                error: function(xhr) {
                    alert('Error loading employee data.');
                }
            });
        });



        // Delete employee
        $(document).on('click', '#delete_employee', function() {
            var employee = $(this).data('id');

            if (confirm('Are you sure you want to delete this employee?')) {
                $.ajax({
                    url: `/employees/${employee}`, // URL delete route
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        // $(`button[data-id="${departmentId}"]`).closest('tr').remove();
                        $(`#employee-${employeeId}`).remove();
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Error deleting employee.');
                    }
                });
            }
        });

        function updateEmployeeTable(employee) {
            var row = `
                <tr id="employee-${employee.id}">
                    <td class="px-6 py-4 whitespace-nowrap">${employee.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${employee.user.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${employee.user.last_name}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${employee.department.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${employee.user.active ? 'Active' : 'Inactive'}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${employee.has_access ? 'Yes' : 'No'} </td>

                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <button data-id="${employee.id}" id="edit_employee" class="edit-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">Edit</button>
                        <button data-id="${employee.id}" id="delete_employee" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700">Delete</button>
                    </td>
                </tr>
            `;

            var existingRow = $(`#employee-${employee.id}`);
            if (existingRow.length > 0) {
                existingRow.replaceWith(row);
            } else {
                $('#table_users tbody').append(row);
            }
        }



        //Departments management
        $(document).ready(function() {
            $('#department-form').on('submit', function(e) {
                e.preventDefault();

                var url = $(this).attr('action');
                var method = $(this).find('input[name="_method"]').val() || 'POST';
                var formData = $(this).serialize();

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function(response) {
                        // $('#department-modal').addClass('hidden');

                        $('#department-form')[0].reset();

                        updateDepartmentTable(response.department);

                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });

        function updateDepartmentTable(department) {
            var row = `
                    <tr id="department-${department.id}">
                        <td class="px-6 py-4 whitespace-nowrap">${department.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${department.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <button data-id="${department.id}" class="edit-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">Edit</button>
                            <button data-id="${department.id}" id="delete-department" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700">Delete</button>
                        </td>
                    </tr>
                `;
            var table = $('#table_departments');
            var existingRow = $(`#department-${department.id}`);
            if (existingRow.length > 0) {
                existingRow.replaceWith(row);
            } else {
                table.find('tbody').append(row);
            }
        }


        // Delete department
        $(document).on('click', '#delete-department', function() {
            var departmentId = $(this).data('id');

            if (confirm('Are you sure you want to delete this department?')) {
                $.ajax({
                    url: `/department/${departmentId}`, // URL to your delete route
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        $(`button[data-id="${departmentId}"]`).closest('tr').remove();
                        alert('Department deleted successfully.');
                    },
                    error: function(xhr) {
                        alert('Error deleting department.');
                    }
                });
            }
        });

        //Edit department
        $(document).on('click', '#edit-department', function() {
            var departmentId = $(this).data('id');
            var departmentName = $(this).closest('tr').find('td:eq(1)').text().trim();

            // Set the form action to update route
            $('#department-form').attr('action', `/department/${departmentId}`);
            $('#method').val('PUT'); // Use PUT method for updating
            $('#department_department_id').val(departmentId);
            $('#department_name').val(departmentName);
            $('#form-button-text').text('Update department');

            $('#department-modal').removeClass('hidden');

        });


        //Bulk load
        $(document).ready(function() {
            // Open modal
            $('[data-modal-toggle="bulk_load-modal"]').on('click', function() {
                $('#bulk_load-modal').removeClass('hidden');
            });

            // Close modal
            $('#bulk_load-modal button[data-modal-toggle="bulk_load-modal"]').on('click', function() {
                $('#bulk_load-modal').addClass('hidden');
            });

            // Close modal when clicking outside of it
            $(window).on('click', function(e) {
                if ($(e.target).is('#bulk_load-modal')) {
                    $('#bulk_load-modal').addClass('hidden');
                }
            });
        });


        $(document).ready(function() {
            $('#csv_file').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const csv = e.target.result;
                        const rows = csv.split('\n');

                        const tableBody = $('#csv-preview-body');
                        tableBody.empty();

                        rows.forEach((row, index) => {
                            const cols = row.split(',');

                            if (cols.length > 1 && index > 0) {
                                tableBody.append(`
                            <tr>
                                <td class="px-6 py-4">${cols[0]}</td>
                                <td class="px-6 py-4">${cols[1]}</td>
                                <td class="px-6 py-4">${cols[2]}</td>
                                <td class="px-6 py-4">${cols[3]}</td>
                                <td class="px-6 py-4">${cols[4]}</td>
                                <td class="px-6 py-4">${cols[5]}</td>
                                <td class="px-6 py-4">
                                    <button class="delete-row block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        `);
                            }
                        });
                    };
                    reader.readAsText(file);
                }
            });

            // Load employee
            $('#submit-csv').on('click', function(e) {
                e.preventDefault();

                const employees = [];

                // Get data table
                $('#csv-preview-body tr').each(function() {
                    const row = $(this).find('td');
                    employees.push({
                        name: row.eq(0).text(),
                        last_name: row.eq(1).text(),
                        email: row.eq(2).text(),
                        password: row.eq(3).text(),
                        department: row.eq(4).text(),
                        access: row.eq(5).text()
                    });
                });

                // Send data
                $.ajax({
                    url: '/upload-employees',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        employees: employees
                    },
                    success: function(response) {
                        alert('Employees loaded successfully');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert("Error: " + xhr.responseJSON.error);
                        } else {
                            alert("An unexpected error occurred.");
                        }
                    }
                });
            });

            // Delete data from table
            $(document).on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>

</body>

</html>
