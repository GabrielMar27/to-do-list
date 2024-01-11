<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <link rel="stylesheet" href="../styles/taskFileStyle.css">
</head>
<body>
<?php
session_start();
include('header.php');
include('../conect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new DataBase();
    $connection = $conn->connect();
    $email = $_SESSION['email'];

    $taskTitle = mysqli_real_escape_string($connection, $_POST['task-title']);
    $taskDesc = mysqli_real_escape_string($connection, $_POST['task-desc']);
    $taskCategory = mysqli_real_escape_string($connection, $_POST['task-category']);
    $taskDeadline = isset($_POST['task-deadline']) ? $_POST['task-deadline'] : '';

    $categoryNumber = 0;
    switch ($taskCategory) {
        case "personal":
            $categoryNumber = 1;
            break;
        case "lucru":
            $categoryNumber = 2;
            break;
        case "scoala":
            $categoryNumber = 3;
            break;
        case "alta":
            $categoryNumber = 4;
            break;
        default:
            $categoryNumber = 1;
            break;
    }

    $insertTaskQuery = "INSERT INTO task (titlu_task, descriere_task, data_creare, data_sfarsit, stare, email, idTaskCat)
                        VALUES ('$taskTitle', '$taskDesc', CURDATE(), '$taskDeadline', 'NeTerminat', '$email', '$categoryNumber')";
    $conn->insert($insertTaskQuery);

    $getLastInsertedTaskIdQuery = "SELECT id_task FROM task ORDER BY id_task DESC LIMIT 1;";
    $result = $conn->query($getLastInsertedTaskIdQuery);
    $row = $result->fetch_assoc();
    $lastInsertedTaskId = $row['id_task'];
    // Verifica daca exista subtaskuri introduse
    if (isset($_POST['subtask'])) {
        $subtasks = $_POST['subtask'];

        // Insereaza subtaskurile în tabelul "subtask"
        foreach ($subtasks as $subtask) {
            $subtask = mysqli_real_escape_string($connection, $subtask);
            $insertSubtaskQuery = "INSERT INTO subtask (textSubtask, id_task)
                                   VALUES ('$subtask', '$lastInsertedTaskId')";
            $conn->insert($insertSubtaskQuery);
        }
    }
}
?>

<form method="POST">
    <label for="task-title">Titlu Task:</label>
    <input type="text" id="task-title" name="task-title" required><br><br>
    
    <label for="task-desc">Descriere Task:</label><br>
    <textarea id="task-desc" name="task-desc" rows="4" cols="50"></textarea><br><br>

    <label for="task-category">Categorie Task:</label>
    <select id="task-category" name="task-category">
        <option value="personal">Personal</option>
        <option value="lucru">Lucru</option>
        <option value="scoala">Scoala</option>
		<option value="scoala">Alta</option>

    </select>
    <div id="new-category-input" style="display:none">
        <label for="new-category">Nume Categorie Noua:</label>
        <input type="text" id="new-category" name="new-category">
    </div>

    <label for="task-deadline">Deadline Task:</label>
    <input type="date" id="task-deadline" name="task-deadline" required><br><br>

    <button type="button" onclick="addSubtaskFields()">Adaugă subtask-uri</button><br><br>

    <div id="subtasks-container"></div><br><br>

    <input type="submit" value="Creează task">
</form>

<script>
function addSubtaskFields() {
    var container = document.getElementById("subtasks-container");
    var index = container.children.length + 1;

    var label = document.createElement("label");
    label.setAttribute("for", "subtask-" + index);

    var input = document.createElement("input");
    input.setAttribute("type", "text");
    input.setAttribute("id", "subtask-" + index);
    input.setAttribute("name", "subtask[]");

    var button = document.createElement("button");
    button.setAttribute("type", "button");
    button.setAttribute("onclick", "removeSubtaskField(this)");
    button.innerHTML = "Șterge";

    container.appendChild(label);
    container.appendChild(input);
    container.appendChild(button);
    container.appendChild(document.createElement("br"));
}

function removeSubtaskField(button) {
    var container = document.getElementById("subtasks-container");
    var input = button.previousSibling;
    var label = input.previousSibling;
    var br = label.previousSibling;
    container.removeChild(button);
    container.removeChild(input);
    container.removeChild(label);
    container.removeChild(br);
    var inputs = document.getElementsByClassName("subtask-input");
    for (var i = 0; i < inputs.length; i++) {
        var num = i + 1;
        inputs[i].setAttribute("id", "subtask-" + num);
        inputs[i].setAttribute("name", "subtask-" + num);
        inputs[i].previousSibling.innerHTML = "Subtask " + num + ":";
    }
    if (inputs.length === 0) {
        container.style.display = "none";
        var addButton = document.getElementById("add-subtask-button");
        addButton.style.display = "block";
    } else {
        container.style.height = (container.offsetHeight - (input.offsetHeight + label.offsetHeight + br.offsetHeight)) + "px";
    }
}
</script>
</body>
</html>
