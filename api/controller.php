<?php

$conn = connectMysql();

// assume api_name is already valid
switch ($api_name) {
    case 'add':
        // needs to validate the request, if the params are set, red!
        $selected = $_POST['selected'];
        break;
    case 'archive':
        $selected = $_GET['selected'];
        break;
    case 'del':
        $selected = $_GET['selected'];
        break;
    case 'update':
        $selected = $_POST['selected'];
        break;
    case 'get-one':
        $selected = $_GET['selected'];
        break;
}
// require the script file that contain the requested function
require API_DIR . "$api_name-api.php";
// call the requested function
call_user_func($selected, $conn);