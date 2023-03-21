<?php
require_once ROOT_DIR . "/functions/functions.php";

function category($conn)
{
    // red! archiving a category should also be archiving related items
    $id = (int) $_POST['id'];
    // $id = 5;
    if (archiveCategory($id, $conn)) {
        // dd($_POST);
        back_to_referer();
    }
    error("Db error");
}

function item(mysqli $conn)
{
    $id = (int) $_POST['id'];
    if (archiveItem($id, $conn)) {
        back_to_referer();
    }
    error("DB error");
}
