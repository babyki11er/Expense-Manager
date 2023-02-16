<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";

_archive_api_main();
function debug()
{
    $_GET['attr'] = CATEGORY;
    $_GET['id'] = 5;
}

function _archive_api_main()
{
    $conn = connectMysql();
    $attr = $_GET['attr'];
    if ($attr === CATEGORY) {
        _archive_api_category($conn);
    }

    if ($attr === ITEM) {
        _archive_api_item($conn);
    }
}

function _validateRequestParams(): void
{
    // do validations
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        error("This api only accept GET method");
    }
    $attr = $_GET['attr'];
    if (!in_array($attr, VALID_ATTRIBUTES)) {
        error("Invalid attribute");
    }
    // validations
    if (!is_numeric($_GET['id'])) {
        error("Id parameter has to be a number");
    }
}

function _archive_api_category($conn)
{
    $id = (int) $_GET['id'];
    $related_items = getItemsByCategory($id, $conn);
    // $id = 5;
    if (($e_code = archiveCategory($id, $conn)) > 0) {
        foreach($related_items as $item) {
            archiveItem($item['id'], $conn);
        }
        redirect("./category.php");
    } else if ($e_code === VALIDATE_ERROR) {
        error("Id doesn't exist");
    } else if ($e_code === DB_ERROR) {
        error("Db error");
    }
}

function _archive_api_item(mysqli $conn)
{
    $id = (int) $_GET['id'];
    if (($e_code = archiveItem($id, $conn)) >= 0) {
        redirect("./item.php");
    } else if ($e_code === -4) {
        error("Id doesn't exist");
    } else if ($e_code === -1) {
        error("Error saving file");
    }
}
