<?php
require_once ROOT_DIR . "/functions/functions.php";

function category($conn)
{
    $id = (int) $_GET['id'];
    // $id = 5;
    if (archiveCategory($id, $conn)) {
        // dd($_GET);
        back_to_referer();
    }
    error("Db error");
}

function item(mysqli $conn)
{
    $id = (int) $_GET['id'];
    if (archiveItem($id, $conn)) {
        back_to_referer();
    }
    error("DB error");
}
