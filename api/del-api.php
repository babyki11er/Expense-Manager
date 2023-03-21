<?php
require_once ROOT_DIR . "/functions/functions.php";

function record(mysqli $conn): void
{
    $id = (int)$_GET['id'];
    // do some validations
    if (deleteRecord($id, $conn)) {
        back_to_referer();
    }
    error("Internal DB error", 500);
}


function income(mysqli $conn) : void
{
    $id = (int)$_GET['id'];
    // do some validations
    if (deleteIncome($id, $conn)) {
        back_to_referer();
    }
    error("Internal DB error", 500);
}
