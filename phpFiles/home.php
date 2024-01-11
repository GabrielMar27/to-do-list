<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../styles/homeStyle.css">
    <link rel="stylesheet" href="../styles/taskStyle.css">
    <link rel="stylesheet" href="../styles/subTaskStyle.css">

</head>
<body>
<?php
session_start();

include('header.php');
include('../conect.php');
$database = new DataBase();


//verifica daca subtaskurile sunt completate
if (isset($_POST['update_task'])) {
    $taskId = $_POST['task_id'];
    $taskStatus = $_POST['task_status'];
    $taskEndDate = $_POST['task_end_date'];

    $allSubtasksCompleted = $database->checkAllSubtasksCompleted($taskId);

    if ($allSubtasksCompleted) {
        $database->updateTask($taskId, $taskStatus, $taskEndDate);
    } else {
        echo "Nu poți declara task-ul ca terminat până când toate subtask-urile nu sunt terminate.";
    }
}
//update stare subtask
if (isset($_POST['update_subtask'])) {
    if (isset($_POST['subtask_status_checkbox'])) {
        $subtaskStatus = $_POST['subtask_status'];
    } else {
        $subtaskStatus = 'NeTerminat';
    }

    $database->updateSubtask($_POST['subtask_id'], $subtaskStatus);
}
//delete task cu subtaskuri
if (isset($_POST['delete_task'])) {
    $taskId = $_POST['task_id'];
    $confirmInput = $_POST['confirm_input'];

    if ($confirmInput === 'confirma') {
        $database->deleteTaskAndSubtasks($taskId);
        echo "Task-ul a fost șters din baza de date.";
    } else {
        echo "Ștergerea task-ului a fost anulată.";
    }
}

$tasks = $database->getTasksWithSubtasks($_SESSION['email']);

// Sortarea listei de task-uri cu o funtie definita de mine
function sortTasksByStatus($task1, $task2)
{
    $status1 = $task1->getStatus();
    $status2 = $task2->getStatus();

    if ($status1 == "NeTerminat" && $status2 == "Terminat") {
        return -1;
    } elseif ($status1 == "Terminat" && $status2 == "NeTerminat") {
        return 1;
    } else {
        return 0; 
    }
}
usort($tasks, "sortTasksByStatus");
echo "<div class='mainConteiner'>";
if (empty($tasks)) {
    echo "Nu ai taskuri adaugate";
} else {

    foreach ($tasks as $task) {
        // Verificăm dacă task-ul este expirat
        $taskContainerClass = ($task->isExpired()) ? 'taskContainer expired' : 'taskContainer';
        echo '<div class="' . $taskContainerClass . '">';

        echo '<div class="taskTitle">Categorie: ' . $task->getCategory() . '</div>';
        echo '<div class="taskTitle">' . $task->getTitle() . '</div>';
        echo '<div class="taskDescription">Data creare: ' . $task->getCreationDate() . '</div>';
        echo '<div class="taskDescription">Descriere task: ' . $task->getDescription() . '</div>';

        // Formular pentru actualizarea starii si deadline-ului
        echo '<form method="POST" action="">';
        echo '<input type="hidden" name="task_id" value="' . $task->getId() . '">';
        echo '<label for="task_end_date">Data sfârșit:</label>';
        echo '<input type="date" name="task_end_date" id="task_end_date" value="' . $task->getEndDate() . '"><br>';
        echo '<label for="task_status">Stare:</label>';
        echo '<select name="task_status" id="task_status">';
        echo '<option value="NeTerminat" ' . ($task->getStatus() == "NeTerminat" ? 'selected' : '') . '>NeTerminat</option>';
        echo '<option value="Terminat" ' . ($task->getStatus() == "Terminat" ? 'selected' : '') . '>Terminat</option>';
        echo '</select>';

        echo '<input type="submit" name="update_task" value="Actualizează">';
        echo '</form>';
        //sterge task cu confimare
        echo '<form method="POST" action="" onsubmit="return confirmTaskDeletion();">';
        echo '<input type="hidden" name="task_id" value="' . $task->getId() . '">';
        echo 'Introduceți "confirma" pentru a șterge task-ul: ';
        echo '<input type="text" name="confirm_input">';
        echo '<input type="submit" name="delete_task" value="Șterge">';
        echo '</form>';

        echo '</div>';

        $subtasks = $task->getSubtasks();

        if (!empty($subtasks)) {
            echo '<div class="subtaskContainer">';
            foreach ($subtasks as $subtask) {
                echo '<div class="subtaskText">Text subtask: ' . $subtask->getText() . '</div>';

                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="subtask_id" value="' . $subtask->getId() . '">';
                echo '<label for="subtask_status">Stare subtask:</label>';
                echo '<input type="hidden" name="subtask_status" value="Terminat">';
                echo '<input type="checkbox" name="subtask_status_checkbox" value="Terminat" ' . ($subtask->getSubStatus() == "Terminat" ? 'checked' : '') . '> Terminat';
                echo '<input type="submit" name="update_subtask" value="Actualizează">';
                echo '</form>';
            }
            echo '</div>';
        }

    }
    echo "</div>";
}
echo '</div>';
?>

</body>
</html>
