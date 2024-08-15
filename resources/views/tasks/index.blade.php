<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">To-Do List</h2>
        <div class="input-group mb-4">
            <input type="text" id="taskInput" class="form-control" placeholder="Add a new task" required>
            <div class="input-group-append">
                <button class="btn btn-primary" id="addTaskButton">Add Task</button>
            </div>
        </div>

        <button class="btn btn-secondary mb-4" id="showAllTasksButton">Show All Tasks</button>

        <table class="table table-bordered" id="taskTable">
            <thead>
                <tr>
                    <th class="s-no">S.No</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $key=>$task)
                <tr data-id="{{ $task->id }}" class="{{ $task->status == 'Completed' ? 'completed-task' : '' }}">
                    <td>{{ ++$key }}</td>
                    <td>
                        <input type="checkbox" class="complete-task" {{ $task->status == 'Completed' ? 'checked' : '' }}>
                        {{ $task->task }}
                    </td>
                    <td>{{ $task->status }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger delete-task">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/task.js') }}"></script>
    <script>
        var token = "{{ csrf_token() }}"
        $(document).ready(function() {
            var url = "{{ route('tasks.store') }}";
            addTask(url, token);
        });

        $(document).on("change", ".complete-task", function() {
            var row = $(this).closest("tr");
            var id = row.data("id");
            var url = `/tasks/${id}/complete`;
            markCompleted(url, token, row);
        });

        $(document).on("click", ".delete-task", function() {
            if (confirm("Are you sure you want to delete this task?")) {
                var row = $(this).closest("tr");
                var id = row.data("id");
                var url = `/tasks/${id}`;
                deleteTask(url, token, row);
            }
        });
    </script>
</body>

</html>