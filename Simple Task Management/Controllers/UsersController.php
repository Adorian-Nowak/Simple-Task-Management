<?php

include '../ViewModel/User/UserDetailsViewModel.php';
include '../ViewModel/User/UserViewModel.php';

$User = new UsersController();

switch ($_GET["action"]) {
    case 'index':
        $User->Index();
        break;
    case 'details':
        $User->Details($_GET['id']);
        break;
    case 'update':
        $User->Update($_GET['id']);
        break;
    case 'delete':
        $User->Delete($_GET['id']);
        break;
    case 'create':
        $User->Create();
        break;
    default:
        $User->Index();
}

class UsersController {
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
        $user = $_GET['user'];
        $status = $_GET['status'];
        if ($status) {
            $Status = "$status = s.id";
        }
        else {
            $Status = 1;
        }
        $sql = 
        "SELECT u.id AS id, t.name AS task, u.name AS user, au.name AS a_user, s.name AS status
        FROM tasks AS t
        LEFT JOIN users AS u ON u.id = t.user_id
        LEFT JOIN users AS au ON au.id = t.assigned_user_id
        LEFT JOIN status AS s ON s.id = t.status_id
        WHERE u.name = '$user' AND '$Status';";

        $Users = $this->conn->query($sql);
    
        $ViewModel = new UserViewModel();

        if ($Users) {
            while ($row = $Users->fetch_assoc()) {
                $ViewModel->Users[] = $row;
            }
        }
        else {
            echo "Error: " . $this->conn->error;
        }

        setcookie('UserViewModel', serialize($ViewModel), time() + (3600), "/");

        header("Location: ../Views/User/index.php");

        exit();
    }

    function Details($id) {
        $status = $_GET['status'];
        if ($status) {
            $Status = "$status = s.id";
        }
        else {
            $Status = 1;
        }
        $sql = 
        "SELECT u.id AS id, t.name AS task, u.name AS user, s.name AS `status`
        FROM users AS u 
        RIGHT JOIN tasks AS t ON u.id = t.user_id 
        LEFT JOIN `status` AS s ON s.id = t.status_id
        WHERE u.id = '$id' AND '$Status';";

        $Users = $this->conn->query($sql);
    
        $ViewModel = new UserDetailsViewModel();

        if ($Users) {
            while ($row = $Users->fetch_assoc()) {
                $ViewModel->Users[] = $row;
            }
        }
        else {
            echo "Error: " . $this->conn->error;
        }

        setcookie('UserDetailsViewModel', serialize($ViewModel), time() + (3600), "/");

        header("Location: ../Views/User/details.php");

        exit();
    }

    function Update($id) {
        $user = $_POST['user'];

        $sql = 
        "UPDATE users SET `name` = '$user' WHERE id = '$id'
        ";

        $this->conn->query($sql);        

        header("Location: ./UsersController.php?action=details&id=$id");

        exit();
    }

    function Delete($id) {
        $sql = 
        "DELETE FROM users WHERE id = '$id';
        ";

        $this->conn->query($sql);

        header("Location: ./UsersController.php?action=index");

        exit();
    }

    function Create() {
        $user = $_POST['user'];

        $sql = 
        "INSERT INTO users (`name`) VALUES ('$user')
        ";

        $this->conn->query($sql);

        header("Location: ./UsersController.php?action=index");

        exit();
    }
}

?>