<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../www/css/Task/index.css">
</head>
<body>

<form id="myform" method="get" action="details.php">

<a href="../../">Leave</a>

<?php

require_once '../../ViewModel/Task/TaskViewModel.php';

if (isset($_COOKIE['TaskViewModel'])) {
    $viewModel = unserialize($_COOKIE['TaskViewModel']);
}
else {
    echo "No data available.";
    exit();
}
echo "<table>
<tr>
    <th><span><a>Task</a><a href='./create.php'>Add Task</a></span></th>
    <th><span><a>User</a><a href='../../Controllers/UsersController.php?action=create'>Add User</span></th>
    <th>Assigned User</th>
    <th>Status</th>
</tr>";
foreach ($viewModel->Tasks as $task) {
    echo "
        
        <tr>
            <td><a href='../../Controllers/TasksController.php?action=details&id=".urlencode($task['id'])."'>".htmlspecialchars($task['task'])."</a> | <a href='../../Controllers/TasksController.php?action=delete&id=".urlencode($task['id'])."'>Delete</a></td>
            <td>".htmlspecialchars($task['user'])."</td>
            <td>".htmlspecialchars($task['a_user'])."</td>
            <td>".htmlspecialchars($task['status'])."</td>
        </tr>

    
    ";

}
echo "</table>";

?>

</form>

</body>