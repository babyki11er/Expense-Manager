<?php
require_once ROOT_DIR . "/functions/functions.php";
function _main() : void
{
    $conn = connectMysql();
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        error("Invalid api method call");
    }
    if (!isset($_GET['selected']) || !isset($_GET['id'])) {
        error("Missing certain parameters!");
    }
    $selected = $_GET['selected'];
    switch($selected) {
        case CATEGORY:
            // category($conn);
            break;
        case ITEM:
            item($conn);
            break;
        default:
            error("Invalid selected parameter value"); 
    }
}

_main();

// function category(mysqli $conn) : void
// {
//     $id = $_GET['id'];
//     apiResponse(getCategoryName($id, $conn));
// }

function item(mysqli $conn) : void
{
    $item_id = $_GET['id'];
    // validating parameter values
    $item = getItemById($item_id, $conn);
    apiResponse($item);
}