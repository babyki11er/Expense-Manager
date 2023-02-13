<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";

_main();
function debug()
{
    $_GET['attr'] = CATEGORY;
    $_GET['id'] = 5;
}
function _main()
{
    $attr = $_GET['attr'];
    if ($attr === CATEGORY) {
        _category();
    }

    if ($attr === ITEM) {
        _item();
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

function _category()
{
    $id = (int) $_GET['id'];
    // $id = 5;
    if (($e_code = archiveCategory($id)) > 0) {
        redirect("./category.php");
    } else if ($e_code === -4) {
        error("Id doesn't exist");
    } else if ($e_code === -1) {
        error("Error saving file");
    }
}

function _item()
{
    $id = (int) $_GET['id'];
    if (($e_code = archiveItem($id)) >= 0) {
        redirect("./item.php");
    } else if ($e_code === -4) {
        error("Id doesn't exist");
    } else if ($e_code === -1) {
        error("Error saving file");
    }
}
