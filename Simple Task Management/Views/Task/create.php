<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../www/css/Task/details.css">
</head>
<body>
    <form method="post" id="Form" action="../../Controllers/TasksController.php?action=create">
                Task <input type='text' name='task' value=''/>
                User <input type='text' name='user' placeholder='optional'/>
                Assigned User <input type='text' name='a_user' placeholder='optional'/>
                <select class='form_elements' id='status' name='status'>
                    <option value='1'>Planned</option>
                    <option value='2'>In progress</option>
                    <option value='3'>Complete</option>
                    <option value='4'>Cancelled</option>
                </select>
                
                <input type="submit" value="Submit">
    </form>
</body>
</html>
