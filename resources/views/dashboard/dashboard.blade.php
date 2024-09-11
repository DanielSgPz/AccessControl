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
            <div class="text-xl font-bold">Logs Panel</div>
            <div>
                @auth
                    <div class="flex mt-2 gap-4 items-center">
                        <p class="text-lg">Welcome: {{ auth()->user()->name }}</p>
                        <a href="{{ route('adminusers') }}"
                            class="border hover:text-gray-900 p-2.5 rounded-md hover:bg-slate-200">Admin Users</a>
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

    <div class="container mx-auto mt-4 mb-4">
        <!--Filters-->
        <div class="w-full">

            <div class="flex flex-col">
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-lg">

                    <form class="" action="{{ route('dashboard') }}" method="GET">
                        <div
                            class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 items-center justify-between">
                            <div class="relative  flex  items-center justify-between rounded-md">
                                <svg class="absolute left-2 block h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" class=""></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" class="">
                                    </line>
                                </svg>
                                <input type="name" name="search"
                                    class="h-12 w-full cursor-text rounded-md border border-gray-100 bg-gray-100 py-4 pl-12 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    placeholder="Search by id, name, last name" />
                            </div>
                            <div class="flex flex-col">
                                <label for="Department" class="text-sm font-medium text-stone-600">Filter by
                                    Department</label>

                                <select name="department" id="department"
                                    class="mt-2 block w-full rounded-md border border-gray-100 bg-gray-100 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="" disabled selected>Select a department</option>

                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col">
                                <label for="initial_date" class="text-sm font-medium text-stone-600">Initial access
                                    date</label>
                                <input type="date" id="initial_date"
                                    class="mt-2 block w-full cursor-pointer rounded-md border border-gray-100 bg-gray-100 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                            <div class="flex flex-col">
                                <label for="date" class="text-sm font-medium text-stone-600">Final access
                                    date</label>
                                <input type="date" id="date"
                                    class="mt-2 block w-full cursor-pointer rounded-md border border-gray-100 bg-gray-100 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>

                            <div class="mt-6 grid w-full grid-cols-2 justify-end space-x-4 md:flex">
                                <button type="submit"
                                    class="rounded-lg bg-blue-600 px-8 py-2 font-medium text-white outline-none hover:opacity-80 focus:ring">Search</button>
                                <button
                                    class="rounded-lg bg-gray-200 px-8 py-2 font-medium text-gray-700 outline-none hover:opacity-80 focus:ring">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg mt-2">
                <div class="flex justify-between">
                    <h4 class="font-bold">Employees List</h4>
                </div>
                <table class="min-w-full divide-y divide-gray-200 bg-white rounded-md shadow-md">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee Id</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Access</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($access as $log)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $log->employee_id ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $log->employee ? $log->employee->user->name : 'Unknown' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $log->employee ? $log->employee->user->last_name : 'Unknown' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $log->employee ? $log->employee->department->name : 'Unknown' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $log->total_accesses }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                    <button data-modal-target="history-modal" data-modal-toggle="history-modal"
                                        data-employee-id="{{ $log->employee_id }}"
                                        class="edit-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4
                                    focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5
                                    text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">History</button>

                                    <a href="{{ route('employees.export-pdf',$log->employee_id) }}"
                                        class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 19l9-7-9-7-9 7 9 7z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 12l9-7-9-7-9 7 9 7z"></path>
                                        </svg>
                                        Export History
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">No access logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- Modal history -->
    <div id="history-modal" tabindex="-1" aria-hidden="true"
        class="flex hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative ">
            <!-- Modal content -->
            <div class="relative p-2 bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-2 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">History
                    </h3>
                    <button type="button" id="close-history-modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="min-w-full divide-gray-200 bg-white rounded-md shadow-md flex mb-2">
                    <span class="px-4 py-4 whitespace-nowrap"> EMPLOYEE ID: <span id="employee-id"></span></span>
                    <span class="px-4 py-4 whitespace-nowrap"> NAME: <span id="employee-name"></span></span>
                    <span class="px-4 py-4 whitespace-nowrap"> LAST NAME: <span id="employee-lastname"></span></span>
                    <span class="px-4 py-4 whitespace-nowrap"> DEPARTMENT: <span
                            id="employee-department"></span></span>
                    <span class="px-4 py-4 whitespace-nowrap"> TOTAL ACCESS: <span id="total-access"></span></span>

                </div>
                <!-- Modal body -->
                <table id="history-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-md shadow-md">
                    <thead>
                        <tr>
                            <th class="px-6 py-3">SUCCESS</th>
                            <th class="px-6 py-3">DETAIL</th>
                            <th class="px-6 py-3">LOG</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <script>
            //Modal history function
            $(document).ready(function() {

                // Open modal
                $('[data-modal-toggle="history-modal"]').on('click', function() {
                    const employeeId = $(this).data(
                        'employee-id'); // Get the employee ID from the button data attribute

                    // Fetch logs for the selected employee
                    $.ajax({
                        url: '{{ route('employeeLogs') }}',
                        type: 'GET',
                        data: {
                            employee_id: employeeId
                        },
                        success: function(data) {
                            const tableBody = $('#history-table tbody');
                            tableBody.empty(); // Clear previous data

                            // Insert new data
                            data.access_logs.forEach(log => {
                                tableBody.append(`
                        <tr>
                            <td class="px-6 py-4">${log.success ? 'OK' : 'Failed'}</td>
                            <td class="px-6 py-4">${log.details}</td>
                            <td class="px-6 py-4">${log.log}</td>
                        </tr>
                    `);
                            });

                            // Update modal content
                            $('#employee-id').text(data.employee_id);
                            $('#employee-name').text(data.employee_name);
                            $('#employee-lastname').text(data.employee_lastname);
                            $('#employee-department').text(data.employee_department);
                            $('#total-access').text(data.total_accesses);

                            // Show modal
                            $('#history-modal').removeClass('hidden');
                        },
                        error: function() {
                            console.error('Error:', error);
                            alert('Failed to fetch logs');
                        }
                    });
                });

                // Close modal
                $('#close-history-modal').on('click', function() {
                    $('#history-modal').addClass('hidden');
                });

                // Close modal
                $(window).on('click', function(e) {
                    if ($(e.target).is('#history-modal')) {
                        $('#history-modal').addClass('hidden');
                    }
                });
            });
        </script>
</body>

</html>
