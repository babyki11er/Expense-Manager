<?php
require_once ROOT_DIR . "/functions/functions.php";
function _main() : void
{
    $conn = connectMysql();
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        error("Invalid api method call");
    }
    if (!isset($_POST['selected']) || !isset($_POST['id'])) {
        error("Missing certain parameters!");
    }
    $selected = $_POST['selected'];
    switch($selected) {
        case CATEGORY:
            // _get_api_category($conn);
            break;
        case ITEM:
            _get_api_item($conn);
            break;
        default:
            error("Invalid selected parameter value"); 
    }
}

_main();

// function _get_api_category(mysqli $conn) : void
// {
//     $id = $_POST['id'];
//     apiResponse(getCategoryName($id, $conn));
// }

function _get_api_item(mysqli $conn) : void
{
    $item_id = $_POST['id'];
    // validating parameter values
    $item = getItemById($item_id, $conn);
    apiResponse($item);
}