<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $item_id = $_GET['id'];
    // validating parameter values
    // if (empty($item_id)) {
    //     error("Invalid or empty parameter value!");
    // }
    $item = getItem($item_id);
    if ($item === DELETED) {
        error("Requested item has been deleted!");
    }
    apiResponse($item);
}
