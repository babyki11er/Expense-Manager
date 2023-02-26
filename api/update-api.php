<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";
_update_api_main();

function _update_api_main(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        error("only accepting POST request");
    }
    if (!isset($_POST['selected']) || !isset($_POST['id'])) {
        error("Missing certain parameters", 400, $_POST);
    }

    $selected = $_POST['selected'];
    $conn = connectMysql();
    switch($selected) {
        case CATEGORY:
            _update_api_category($conn);
            break;
        case ITEM:
            _update_api_item($conn);
            break;
        case RECORD:
            _update_api_record($conn);
            break;
        case INCOME:
            _update_api_income($conn);
            break;
        default:
            error("Missing or invalid parameter values!");
    }
}


function _update_api_category(mysqli $conn) : void
{
    // dd($_POST);
    $id = (int)$_POST['id'];
    $value = $_POST['value'];
    if (($id = updateCategory($id, $value, $conn)) >= 0) {
        redirect('./category.php');
    } else if ($id === VALIDATE_ERROR) {
        error('Invalid api call', 404, $_POST);
    } else if ($id === DB_ERROR) {
        error('Internal DB error');
    }
}
    // $id = $_POST['id'];

function _update_api_item(mysqli $conn) : void
{
    // dd($_POST);
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $cat_id = $_POST['cat_id'];
    if (isset($_POST['overwrite']))
    {
        if (($id = updateItem($id, $name, $price, $cat_id, $conn)) >= 0) {
            redirect('./item.php');
        } else if ($id === VALIDATE_ERROR) {
            error('Invalid api call', 404);
        } else if ($id === DB_ERROR) {
            error('Internal DB error');
        }
    }
    else if (isset($_POST['keep']))
    {
        $name = $name . $name[-1];
        if (addNewItem($name, $price, $cat_id, $conn) >= 0) {
            redirect('./item.php');
        } else {
            // need to consider validate error and db
            error("ERror saving the item", 400, $_POST);
        }
    }
    else
    {
        archiveItem($id, $conn);
        if (addNewItem($name, $price, $cat_id, $conn) >= 0) {
            redirect('./item.php');
        } else {
            // need to consider validate error and db
            error("ERror saving the item", 400, $_POST);
        }
    }
}

function _update_api_record(mysqli $conn) : void
{
    // validating the parameters
    if (
        !isset($_POST['item_id']) ||
        !isset($_POST['note']) ||
        !isset($_POST['qty']) ||
        !isset($_POST['date'])
    ) {
        $keys = array_keys($_POST);
        error("Plese, input all parameters!", 400, $keys);
    }
    $id = $_POST['id'];
    $item_id = $_POST['item_id'];
    $qty = $_POST['qty'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    if (($id = updateRecord($id, $item_id, $qty, $date, $note, $conn)) >= 0) {
        // apiResponse(getRecordsPublic($conn));
        redirect('./item.php');
    } else if ($id === VALIDATE_ERROR) {
        error('Invalid api call', 404);
    } else if ($id === DB_ERROR) {
        error('Internal DB error');
    }
}
function _update_api_income(mysqli $conn) : void
{
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $label = $_POST['label'];
    if (($id = updateIncome($id, $amount, $label, $date, $note, $conn)) >= 0) {
        redirect('./income.php');
    } else if ($id === VALIDATE_ERROR) {
        error('Invalid api call', 404);
    } else if ($id === DB_ERROR) {
        error('Internal DB error');
    }
}