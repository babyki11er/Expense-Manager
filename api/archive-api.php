<?php
require_once ROOT_DIR . "/functions/functions.php";

main();
function debug()
{
    $_GET['selected'] = CATEGORY;
    $_GET['id'] = 5;
}

function main()
{
    $conn = connectMysql();
    // dd($_GET);
    $selected = $_GET['selected'];
    if ($selected == CATEGORY) {
        category($conn);
    }
    if ($selected == ITEM) {
        item($conn);
    }
    error("Invalid api call.");
}

function _validateRequestParams(): void
{
    // do validations
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        error("This api only accept GET method");
    }
    $selected = $_GET['selected'];
    if (!in_array($selected, VALID_SELECTORS)) {
        error("Invalid selected");
    }
    // validations
    if (!is_numeric($_GET['id'])) {
        error("Id parameter has to be a number");
    }
}

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
