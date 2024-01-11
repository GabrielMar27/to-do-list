<?php
    include('../taskClass.php');
    include('../subTaskClass.php');
class DataBase
{
    private $conn;

    function connect()
    {
        $this->conn = mysqli_connect('localhost', 'root', '', 'to-dolist', '3306') or die('Connection failed!');
        return $this->conn;
    }

    function read($query)
    {
        $connection = $this->connect();
        $result = mysqli_query($connection, $query);

        if (!$result) {
            return [];
        } else {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    function insert($query)
    {
        $connection = $this->connect();
        $result = mysqli_query($connection, $query);
        if (!$result) {
            return false;
        } else {
            return mysqli_insert_id($connection);
        }
    }

    function query($query)
    {
        $connection = $this->connect();
        return mysqli_query($connection, $query);
    }
    public function checkAllSubtasksCompleted($taskId) {
        // Obține subtask-urile asociate task-ului din baza de date
        $subtasks = $this->getSubtasksForTask($taskId);

        // Parcurge subtask-urile și verifică starea lor
        foreach ($subtasks as $subtask) {
            if ($subtask->getSubStatus() != "Terminat") {
                return false;
            }
        }

        return true; // Toate subtask-urile sunt terminate
    }
    public function getSubtasksForTask($taskId) {
        $connection = $this->connect();

        $taskId = mysqli_real_escape_string($connection, $taskId);

        $query = "SELECT * FROM subtask WHERE id_task = '$taskId'";
        $result = mysqli_query($connection, $query);

        $subtasks = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $subtask = new Subtask();
                $subtask->setId($row['idSubtask']);
                $subtask->setText($row['textSubtask']);
                $subtask->setSubStatus($row['stareSub']);
                $subtasks[] = $subtask;
            }
        }

        mysqli_close($connection);

        return $subtasks;
    }
    public function getTasksWithSubtasks($email)
{

    $query = "SELECT subtask.stareSub, categorie.numeCategorie, task.id_task, task.titlu_task, task.descriere_task, task.data_creare, task.data_sfarsit, task.stare, task.email, subtask.idSubtask, subtask.textSubtask
              FROM task
              LEFT JOIN subtask ON task.id_task = subtask.id_task 
              LEFT JOIN categorie ON task.idTaskCat = categorie.idTaskCat
              WHERE task.email = '$email'";

    $results = $this->read($query);

    $tasks = array();
    $currentTask = null;

    foreach ($results as $row) {
        $taskId = $row['id_task'];

        if ($currentTask == null || $taskId != $currentTask->getId()) {
            // Creare un nou obiect Task
            $currentTask = new Task();
            $currentTask->setId($taskId);
            $currentTask->setTitle($row['titlu_task']);
            $currentTask->setDescription($row['descriere_task']);
            $currentTask->setCreationDate($row['data_creare']);
            $currentTask->setEndDate($row['data_sfarsit']);
            $currentTask->setStatus($row['stare']);
            $currentTask->setEmail($row['email']);
            $currentTask->setCategory($row['numeCategorie']);
            $currentTask->setSubtasks(array());
            $tasks[] = $currentTask;
        }

        if ($row['idSubtask'] != null) {
            $subtask = new Subtask();
            $subtask->setId($row['idSubtask']);
            $subtask->setText($row['textSubtask']);
            $subtask->setSubStatus($row['stareSub']);
            $currentTask->addSubtask($subtask);
        }
    }

    return $tasks;
}
public function updateTask($taskId, $status, $endDate) {
    $connection = $this->connect();

    $status = mysqli_real_escape_string($connection, $status);
    $endDate = mysqli_real_escape_string($connection, $endDate);
    $taskId = mysqli_real_escape_string($connection, $taskId);

    $query = "UPDATE task SET stare = '$status', data_sfarsit = '$endDate' WHERE id_task = '$taskId'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);

    return $result;
}

public function updateSubtask($subtaskId, $status) {
    $connection = $this->connect();

    $status = mysqli_real_escape_string($connection, $status);
    $subtaskId = mysqli_real_escape_string($connection, $subtaskId);

    // Setează valoarea 1 pentru "Terminat" și 0 pentru "NeTerminat"

    $query = "UPDATE subtask SET stareSub = '$status' WHERE idSubtask = '$subtaskId'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);

    return $result;
}
public function deleteTaskAndSubtasks($taskId) {
    $connection = $this->connect();

    $taskId = mysqli_real_escape_string($connection, $taskId);

    // Șterge subtaskurile asociate taskului
    $query = "DELETE FROM subtask WHERE id_task = '$taskId'";
    $result = mysqli_query($connection, $query);

    // Șterge taskul
    $query = "DELETE FROM task WHERE id_task = '$taskId'";
    $result = mysqli_query($connection, $query);

    mysqli_close($connection);

    return $result;
}

}
?>
