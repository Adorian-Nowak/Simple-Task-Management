<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../www/css/User/details.css">
</head>
<body>
    <form method="post" id="Form" action="../../Controllers/UsersController.php">
        <?php
        require_once '../../ViewModel/User/UserDetailsViewModel.php';
        if (isset($_COOKIE['UserDetailsViewModel'])) {
            $viewModel = unserialize($_COOKIE['UserDetailsViewModel']);
        } else {
            echo "No data available.";
            exit();
        }
        foreach ($viewModel->Users as $user) {
            echo "
                User <input type='text' name='user' value='".htmlspecialchars($user['user'])."'/>
                <span>
                    <a href='#' onclick=\"submitFormWithAction('../../Controllers/UsersController.php?action=index');\">Return</a>
                    <a href='#' onclick=\"submitFormWithAction('../../Controllers/UsersController.php?action=update&id=".urlencode($user['id'])."');\">Save</a>
                    <a href='#' onclick=\"submitFormWithAction('../../Controllers/UsersController.php?action=delete&id=".urlencode($user['id'])."');\">Delete</a>
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
