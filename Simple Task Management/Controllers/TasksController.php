<?php

include '../ViewModel/Task/TaskDetailsViewModel.php';
include '../ViewModel/Task/TaskViewModel.php';

$Task = new TasksController();

switch ($_GET["action"]) {
    case 'index':
        $Task->Index();
        break;
    case 'details':
        $Task->Details($_GET['id']);
        break;
    case 'update':
        $Task->Update($_GET['id']);
        break;
    case 'delete':
        $Task->Delete($_GET['id']);
        break;
    case 'create':
        $Task->Create();
        break;
    default:
        $Task->Index();
}

class TasksController {
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli ('localhost', 'root', '', 'task_management');

        if ($this->conn->connect_error) {
            die ("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct()
    {
        $this->conn->close();
        
    }

    function Index() {
        $status = $_GET['status'];
        if ($status) {
            $WHERE = "WHERE $status = s.id";
        }
        $sql = 
        "SELECT t.id AS id, t.name AS task, u.name AS user, au.name AS a_user, s.name AS status
        FROM tasks AS t
        LEFT JOIN users AS u ON u.id = t.user_id
        LEFT JOIN users AS au ON au.id = t.assigned_user_id
        LEFT JOIN status AS s ON s.id = t.status_id
        $WHERE;";

        $Tasks = $this->conn->query($sql);
    
        $ViewModel = new TaskViewModel();

        if ($Tasks) {
            while ($row = $Tasks->fetch_assoc()) {
                $ViewModel->Tasks[] = $row;
            }
        }
        else {
            echo "Error: " . $this->conn->error;
        }

        setcookie('TaskViewModel', serialize($ViewModel), time() + (3600), "/");

        header("Location: ../Views/Task/index.php");

        exit();
    }

    function Details($id) {
        $sql = 
        "SELECT t.id AS id, t.name AS task, u.name AS user, au.name AS a_user, s.name AS status
        FROM tasks AS t
        LEFT JOIN users AS u ON u.id = t.user_id
        LEFT JOIN users AS au ON au.id = t.assigned_user_id
        LEFT JOIN status AS s ON s.id = t.status_id
        WHERE $id = t.id;";

        $Tasks = $this->conn->query($sql);
    
        $ViewModel = new TaskDetailsViewModel();

        if ($Tasks) {
            while ($row = $Tasks->fetch_assoc()) {
                $ViewModel->Tasks[] = $row;
            }
        }
        else {
            echo "Error: " . $this->conn->error;
        }


        setcookie('TaskDetailsViewModel', serialize($ViewModel), time() + (3600), "/");

        header("Location: ../Views/Task/details.php");

        exit();
    }

    function Update($id) {
        $user = $_POST['user'];
        $a_user = $_POST['a_user'];

        $sql1 = 
        "SELECT id FROM users WHERE name = '$user'
        ";
        $sql2 = 
        "SELECT id FROM users WHERE name = '$a_user'
        ";

        $Task1 = $this->conn->query($sql1);
        $Task2 = $this->conn->query($sql2);

        $stmt = $this->conn->prepare("UPDATE tasks SET `name`=?, user_id=?, assigned_user_id=?, status_id=? WHERE id=?");
        $stmt->bind_param("ssssi", $_POST['task'], $Task1->fetch_assoc()['id'], $Task2->fetch_assoc()['id'], $_POST['status'], $id);
        $stmt->execute();
        

        header("Location: ./TasksController.php?action=details&id=$id");

        exit();
    }

    function Delete($id) {
        $sql = 
        "DELETE FROM tasks WHERE id = '$id';
        ";

        $this->conn->query($sql);

        header("Location: ./TasksController.php?action=index");

        exit();
    }

    function Create() {
        $task = $_POST['task'];
        $user = $_POST['user'];
        $a_user = $_POST['a_user'];
        $status = $_POST['status'];

        $sql1 = 
        "SELECT id FROM users WHERE name = '$user'
        ";
        $sql2 = 
        "SELECT id FROM users WHERE name = '$a_user'
        ";

        $Task1 = $this->conn->query($sql1);
        $User = ($Task1->fetch_assoc()['id'] ?? null);
        $Task2 = $this->conn->query($sql2);
        $A_user = ($Task2->fetch_assoc()['id'] ?? null);

        if ($User && $A_user)
            $sql = 
            "INSERT INTO tasks (`name`, user_id, assigned_user_id, status_id) VALUES ('$task', '$User', '$A_user', '$status');
            ";
        if ($User && !$A_user)
            $sql = 
            "INSERT INTO tasks (`name`, user_id, assigned_user_id, status_id) VALUES ('$task', '$User', NULL, '$status');
            ";
        if (!$User && $A_user)
            $sql = 
            "INSERT INTO tasks (`name`, user_id, assigned_user_id, status_id) VALUES ('$task', NULL, '$A_user', '$status');
            ";
        if (!$User && !$A_user)
            $sql = 
            "INSERT INTO tasks (`name`, user_id, assigned_user_id, status_id) VALUES ('$task', NULL, NULL, '$status');
            ";

        $this->conn->query($sql);

        header("Location: ./TasksController.php?action=index");

        exit();
    }
}

?>