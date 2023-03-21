<?php
require_once ROOT_DIR . "/functions/functions.php";

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