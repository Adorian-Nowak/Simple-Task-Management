<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../www/css/Task/details.css">
</head>
<body>
    <form method="post" id="Form" action="../../Controllers/TasksController.php">
        <?php
        require_once '../../ViewModel/Task/TaskDetailsViewModel.php';
        if (isset($_COOKIE['TaskDetailsViewModel'])) {
            $viewModel = unserialize($_COOKIE['TaskDetailsViewModel']);
        } else {
            echo "No data available.";
            exit();
        }
        foreach ($viewModel->Tasks as $task) {
            echo "
                Task <input type='text' name='task' value='".htmlspecialchars($task['task'])."'/>
                User <input type='text' name='user' value='".htmlspecialchars($task['user'])."'/>
                Assigned User <input type='text' name='a_user' value='".htmlspecialchars($task['a_user'])."'/>
                <select class='form_elements' id='status' name='status'>
                    <option ". ($task['status'] == 1 ? "selected" : "") ." value='1'>Planned</option>
                    <option ". ($task['status'] == 2 ? "selected" : "") ." value='2'>In progress</option>
                    <option ". ($task['status'] == 3 ? "selected" : "") ." value='3'>Complete</option>
                    <option ". ($task['status'] == 4 ? "selected" : "") ." value='4'>Cancelled</option>
                </select>
                <span>
                    <a href='#' onclick=\"submitFormWithAction('../../Controllers/TasksController.php?action=index');\">Return</a>
                    <a href='#' onclick=\"submitFormWithAction('../../Controllers/TasksController.php?action=update&id=".urlencode($task['id'])."');\">Save</a>
                    <a href='#' onclick=\"submitFormWithAction('../../Controllers/TasksController.php?action=delete&id=".urlencode($task['id'])."');\">Delete</a>
                </span>";
        }
        ?>
    </form>
</body>
</html>

<script>
function submitFormWithAction(actionUrl) {
    var form = document.getElementById('Form');
    form.action = actionUrl;
    form.submit();
}
</script>
