<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php';

_get_many_api_main();
function _get_many_api_main() : void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    {
        error("Only accpting GET method");
    }
    if (!isset($_GET['selected'])) {
        error("Missing parameters!");
    }
    $selected = $_GET['selected'];
    $conn = connectMysql();
    switch($selected) {
        case CATEGORY:
            _get_many_api_category($conn);
            break;
        case ITEM:
            _get_many_api_item_names($conn);
            break;
        case RECORD:
            _get_many_api_records($conn);
            break;
        default:
            error("Invalid value for selected");
    }
}

function _get_many_api_category(mysqli $conn) : void
{
    // validating
    $categories = listCategories($conn);
    apiResponse($categories);
}

function _get_many_api_item_names(mysqli $conn) : void
{
    $items = getItemNames($conn);
    apiResponse($items);
}

function _get_many_api_records(mysqli $conn) : void
{
    apiResponse(getRecordsPublic($conn));
}