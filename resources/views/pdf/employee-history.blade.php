<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    @if (isset($employee))
        <h2>Access History for {{ $employee->user->name }} {{ $employee->user->last_name }}</h2>
        <p>Id Employee: {{ $employee->id }}</p>
        <p>Department: {{ $employee->department->name }}</p>
    @else
        <h2>Unregistered Access Attempts</h2>
        <p>Displaying access attempts from users who are not registered in the system.</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Log ID</th>
                <th>Success</th>
                <th>Detail</th>
                <th>Log Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $log)
                <tr>
                    <td>{{ $log->id ?? 'Unknown' }}</td>
                    <td>{{ $log->success ? 'Yes' : 'No' }}</td>
                    <td>{{ $log->detail }}</td>
                    <td>{{ $log->log }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
