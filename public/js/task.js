// Add Task
function addTask(url, token) {
    $("#addTaskButton").on("click", function () {
        var task = $("#taskInput").val().trim();
        var rowCount = $("#taskTable tbody tr").length;
        if (task !== "") {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: token,
                    task: task,
                },
                success: function (data) {
                    var newRow = `<tr data-id="${data.id}">
                                    <td>${rowCount + 1}</td>
                                    <td>
                                        <input type="checkbox" class="complete-task">
                                        ${data.task}
                                    </td>
                                    <td>${data.status}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger delete-task">Delete</button>
                                    </td>
                                </tr>`;
                    $("#taskTable tbody").append(newRow);
                    $("#taskInput").val("");
                },
                error: function (xhr) {
                    if (xhr.status == 422) {
                        alert("Task already exists!");
                    }
                },
            });
        }
    });
}

// Mark Task as Completed
function markCompleted(url, token, row) {
    $.ajax({
        url: url,
        type: "PATCH",
        data: {
            _token: token,
        },
        success: function () {
            row.fadeOut("slow", function () {
                row.remove();
            });
        },
    });
}

// Show All Tasks
$("#showAllTasksButton").on("click", function () {
    $.get("/tasks/show-all", function (data) {
        var taskTable = $("#taskTable tbody");
        taskTable.empty();

        counter = 1;

        data.forEach(function (task) {
            // Determine if the row should have the 'completed-task' class
            var completedClass =
                task.status == "Completed" ? "completed-task" : "";
            var row = `<tr data-id="${task.id}" class="${completedClass}">
                            <td>${counter}</td>
                            <td>
                                <input type="checkbox" class="complete-task" ${
                                    task.status == "Completed" ? "checked" : ""
                                }>
                                ${task.task}
                            </td>
                            <td>${task.status}</td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-task">Delete</button>
                            </td>
                        </tr>`;
            taskTable.append(row);
            counter++;
        });
    });
});

// Delete Task
function deleteTask(url,token,row){
    $.ajax({
        url: url,
        type: "DELETE",
        data: {
            _token: token,
        },
        success: function () {
            row.remove();
        },
    });
}
        
