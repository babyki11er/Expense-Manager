<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";
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
//     $id = $_GET['id'];
//     apiResponse(getCategoryName($id, $conn));
// }

function _get_api_item(mysqli $conn) : void
{
    $item_id = $_GET['id'];
    // validating parameter values
    $item = getItem($item_id, $conn);
    apiResponse($item);
}