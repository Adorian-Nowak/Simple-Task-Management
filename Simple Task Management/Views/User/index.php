<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../www/css/User/index.css">
</head>
<body>

<form id="myform" method="get" action="details.php">

<a href="../../">Leave</a>

<?php

require_once '../../ViewModel/User/UserViewModel.php';

if (isset($_COOKIE['UserViewModel'])) {
    $viewModel = unserialize($_COOKIE['UserViewModel']);
}
else {
    echo "No data available.";
    exit();
}
echo "<table>
<tr>
    <th><span><a>Task</a><a href='../Task/create.php'>Add Task</a></span></th>
    <th><span><a>User</a><a href='./create.php'>Add User</span></th>
    <th>Assigned User</th>
    <th>Status</th>
</tr>";
foreach ($viewModel->Users as $user) {
    echo "
        
        <tr>
            <td><a href='../../Controllers/TasksController.php?action=details&id=".urlencode($user['id'])."'>".htmlspecialchars($user['task'])."</a> | <a href='../../Controllers/UsersController.php?action=delete&id=".urlencode($user['id'])."'>Delete</a></td>
            <td><a href='../../Controllers/UsersController.php?action=details&id=".urlencode($user['id'])."'>".htmlspecialchars($user['user'])."</a></td>
            <td>".htmlspecialchars($user['a_user'])."</td>
            <td>".htmlspecialchars($user['status'])."</td>
        </tr>

    
    ";

}
echo "</table>";

?>

</form>

</body>