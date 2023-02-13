<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $attr = $_GET['attr'];
    if ($attr === ITEM) {
        apiResponse(getItemsPublic());
    }
    error("Invalid GET parameters!");
}
