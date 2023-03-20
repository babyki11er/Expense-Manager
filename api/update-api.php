<?php
// require_once ROOT_DIR . "/functions/functions.php";
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
        back_to_referer();
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
            back_to_referer();
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
            back_to_referer();
        } else {
            // need to consider validate error and db
            error("ERror saving the item", 400, $_POST);
        }
    }
    else
    {
        archiveItem($id, $conn);
        if (addNewItem($name, $price, $cat_id, $conn) >= 0) {
            back_to_referer();
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
        !isset($_POST['date']) ||
        !isset($_POST['id'])
    ) {
        $keys = array_keys($_POST);
        // error("Plese, input all parameters!", 400, $keys);
    }
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_cat_id = $_POST['item_cat_id'];
    // case with newly created item
    if (($item_id = existItem($item_name, $item_price, $item_cat_id, $conn)) === NOT_EXIST) {
        $item_id = addNewItem($item_name, $item_price, $item_cat_id, $conn);
        noti("Item added because the selected one doesn't match with the input values");
        LogConsole(implode(',', getItemById($item_id, $conn)));
    }

    if (($id = updateRecord($id, $item_id, $qty, $date, $note, $conn)) >= 0) {
        back_to_referer();
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
    // red! error here
    if (($id = updateIncome($id, $amount, $label, $date, $note, $conn)) >= 0) {
        back_to_referer();
    } else if ($id === VALIDATE_ERROR) {
        error('Invalid api call', 404);
    } else if ($id === DB_ERROR) {
        error('Internal DB error');
    }
}