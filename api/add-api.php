<?php

require_once ROOT_DIR . "/functions/functions.php";

function category(mysqli $conn): void
{
    $cat_string = $_POST['value'];
    // validate the value
    if (empty($cat_string)) {
        error("Category cannot be empty");
    }

    if (( $id = existCategory($cat_string, $conn)) >= 0) {
        $error_code = unarchiveCategory($id, $conn);
    } else {
        $error_code = addNewCategory($cat_string, $conn);
    }

    if ($error_code >= 0) {
        redirect(route("categories"), "$cat_string has been successfully added!");
    }
    error("Internal DB Error", 500);
}

function item(mysqli $conn): void
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
        redirect(route("items"), "$item_name has been successfully added!");
    } else {
        apiResponse($_POST);
        // error("Error saving the item!");
    }
    error("Internal DB Error", 500);
}

function record(mysqli $conn) : void
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
    // case with newly created item
    if ($item_id == -1) {
        $item_id = addNewItem($item_name, $item_price, $item_cat_id, $conn);
    } else {
        $selected_item = getItemById($item_id, $conn);
        if (
            $selected_item['name'] != $item_name ||
            $selected_item['price'] != $item_price ||
            $selected_item['cat_id'] != $item_cat_id
            )
        {
            // if the item id not equal the request params
            $item_id = addNewItem($item_name, $item_price, $item_cat_id, $conn);
            noti("Item added because the selected one doesn't match with the input values");
            LogConsole(implode(',', getItemById($item_id, $conn)));
        }
    }
    // actual inserting data
    $id_added = addNewRecord($item_id, $qty, $date, $note, $conn);
    if ($id_added >= 0) {
        _ssSet('insert-date', $date);
        redirect(route("records"), "Record $id_added# has been added!");
    }
    error("Internal DB Error", 500);
}

function income(mysqli $conn): void
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
        redirect(route("incomes"), "Income has been added successfully");
    }
    error("Internal DB Error", 500);
}
