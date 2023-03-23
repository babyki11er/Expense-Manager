<?php
require_once ROOT_DIR . "/functions/functions.php";

function category($conn)
{
    $id = (int) $_POST['id'];
    if (archiveCategory($id, $conn)) {
        back_to_referer("Category archived successfully");
    }
    error("Db error");
}

function item(mysqli $conn)
{
    $id = (int) $_POST['id'];
    if (archiveItem($id, $conn)) {
        back_to_referer("Item archived successfully");
    }
    error("DB error");
}
