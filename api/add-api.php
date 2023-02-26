<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";

_main();

function _main()
{
    _validateRequestParams();

    $selected = $_POST['selected'];
    if (!in_array($selected, VALID_SELECTORS)) {
        error("Invalid 'selected' parameter value!");
    }

    $conn = connectMysql();
    if ($selected === CATEGORY) {
        _add_api_category($conn);
    }

    if ($selected === ITEM) {
        _add_api_item($conn);
    }

    if ($selected === RECORD) {
        _add_api_record($conn);
    }

    if ($selected === INCOME) {
        _add_api_income($conn);
    }
}

function _add_api_category(mysqli $conn): void
{
    $cat_string = $_POST['value'];
    // validate the value
    if (empty($cat_string)) {
        error("Category cannot be empty");
    }
    if (($error_code = addNewCategory($cat_string, $conn)) > 0) {
        redirect('category.php');
    } else if ($error_code === VALIDATE_ERROR) {
        error("Category already exist.");
    } else if ($error_code === DB_ERROR) {
        error(("Internal Server Error"));
    }
}

function _validateRequestParams(): void
{
    // validating request parameters
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        error("This is not a {$_SERVER['REQUEST_METHOD']} api!", 400, $_REQUEST);
    }
    if (!isset($_POST['selected'])) {
        error("Not setting 'selected' parameter. Did you call me mistakenly?");
    }
}

function _add_api_item(mysqli $conn): void
{
    // validation
    if (!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['cat_id'])) {
        error("Certain parameters are required");
    }
    $item_name = $_POST['name'];
    $item_price = (int) $_POST['price'];
    $item_cat_id = (int) $_POST['cat_id'];
    // validation stuffs
    if (empty($item_name) || empty($item_price)) {
        error("Params for name and price cannot be empty!");
    }
    // actually adding the stuff
    if (($id_new_item = addNewItem($item_name, $item_price, $item_cat_id, $conn)) >= 0) {
        redirect('item.php');
    } else {
        apiResponse($_POST);
        // error("Error saving the item!");
    }
}

function _add_api_record(mysqli $conn)
{
    // validating the parameters
    if (
        !isset($_POST['item_id']) ||
        !isset($_POST['item_name']) ||
        !isset($_POST['item_price']) ||
        !isset($_POST['item_cat_id']) ||
        !isset($_POST['note']) ||
        !isset($_POST['qty']) ||
        !isset($_POST['date']) ||
        !isset($_POST['coffee'])
    ) {
        $keys = array_keys($_POST);
        error("Plese, input all parameters!", 400, $keys);
    }

    $item_id = $_POST['item_id'];
    $qty = $_POST['qty'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_cat_id = $_POST['item_cat_id'];
    if (!is_numeric($qty) || !is_numeric($item_price) || !is_numeric($item_id)) {
        dd($_POST);
        // error("Invalid parameter values!\nMissing int value");
    }
    // do some validation
    if ($item_id == -1) {
        // do some validation
        $item_id = addNewItem($item_name, $item_price, $item_cat_id, $conn);
    } else {
        $selected_item = getItem($item_id, $conn);
        if (
            $selected_item['name'] != $item_name ||
            $selected_item['price'] != $item_price ||
            $selected_item['cat_id'] != $item_cat_id
        ) {
            $item_id = addNewItem($item_name, $item_price, $item_cat_id, $conn);
            noti("Item added because the selected one doesn't match with the input values");
            LogConsole(implode(',', getItem($item_id, $conn)));
        }
        // if the item id not equal the request params
    }
    // actual inserting data
    $id_added = addNewRecord($item_id, $qty, $date, $note, $conn);
    if ($id_added === -1) {
        error("Error addding your record", 400, $_POST);
    } else {
        redirect("./insert.php");
    }
}

function _add_api_income(mysqli $conn): void
{
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $label = $_POST['label'];
    // do validations
    if (!is_numeric($amount)) {
        error("Insert a numeric value for amount");
    }
    if (addIncome($amount, $label, $date, $note, $conn) >= 0) {
        redirect("./income.php");
    } else {
        error("Unknown error occurred", 400, $_POST);
    }
}
