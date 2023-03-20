<?php

$conn = connectMysql();

// assume api_name is already valid
switch ($api_name) {
    case 'add':
        // needs to validate the request, if the params are set, red!
        validate_isset_http('POST', ['selected']);
        $selected = $_POST['selected'];

        // custom validation according to the api rule
        if (!in_array($selected, VALID_SELECTORS)) {
            error("Invalid selected");
        }
        break;
    case 'archive':
        validate_isset_http('GET', ['selected', 'id']);
        $selected = $_GET['selected'];

        // custom validation according to the api rule
        if (!in_array($selected, [CATEGORY, ITEM])) {
            error("Invalid selected resource");
        }
        if (!is_numeric($_GET['id'])) {
            error("Id parameter has to be a number");
        }
        break;
    case 'del':
        validate_isset_http("GET", ['id', 'selected']);
        $selected = $_GET['selected'];

        // custom validation according to the api rule
        if (!is_numeric($_GET['id'])) {
            error("id parameter has to be a number. don't fuck with delete api!");
        }
        if (!isset($_GET['del'])) {
            error("No del paramter. Did you call me mistakenly? Don't fuck with delete api please");
        }
        if (!in_array($selected, [RECORD, INCOME])) {
            error("Invalid 'selected' param.");
        }
        break;
    case 'update':
        validate_isset_http('POST', ['id', 'selected']);
        $selected = $_POST['selected'];

        // custom validation according to the api rule
        if (!in_array($selected, VALID_SELECTORS)) {
            error("Invalid 'selected' param.");
        }
        break;
    case 'get-one':
        validate_isset_http("GET", ["selected", "id"]);
        $selected = $_GET['selected'];

        // custom validation according to the api rule
        if (!in_array($selected, [ITEM])) {
            error("Invalid selected param.");
        }
        break;
}
// require the script file that contain the requested function
require API_DIR . "$api_name-api.php";
// call the requested function
call_user_func($selected, $conn);
