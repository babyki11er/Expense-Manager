<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";

_main();

function _main()
{
    _validateRequestParams();

    $attribute = $_POST['attr'];
    if (!in_array($attribute, VALID_ATTRIBUTES)) {
        error("Invalid 'attr' parameter value!");
    }

    if ($attribute === CATEGORY)
    {
        _category();
    }

    if ($attribute === ITEM)
    {
        _item();
    }

    if ($attribute === RECORD)
    {
        _record();
    }

    if ($attribute === 'income')
    {
        _income();
    }

}

function _category() : void
{
    $cat_string = $_POST['value'];
    // validate the value
    if (empty($cat_string)) {
        error("Category cannot be empty");
    }
    if (($error_code = addNewCategory($cat_string)) > 0) {
        redirect('category.php');
    } else if ($error_code === -4) {
        error("Category already exist.");
    } else if ($error_code === -1) {
        error(("Error writing the json file!"));
    }
}

function _validateRequestParams() : void
{
    // validating request parameters
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        error("This is not a {$_SERVER['REQUEST_METHOD']} api!", 400, $_REQUEST);
    }
    if (!isset($_POST['attr'])) {
        error("Not setting 'attr' parameter. Did you call me mistakenly?");
    }
}

function _item() : void
{
    // validation
    if (!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['cat-id'])) {
        error("Certain parameters are required");
    }
    $item_name = $_POST['name'];
    $item_price = (int) $_POST['price'];
    $item_cat_id = (int) $_POST['cat-id'];
    // validation stuffs
    if (empty($item_name) || empty($item_price)) {
        error("Params for name and price cannot be empty!");
    }
    if (getCategory($item_cat_id) === DELETED) {
        error("Category is already deleted!");
    }
    // actually adding the stuff
    if (($id_new_item = addNewItem($item_name, $item_price, $item_cat_id)) >= 0) {
        redirect('item.php');
    } else {
        error("Error saving the item!");
    }
}

function _record()
{
    // validating the parameters
    if (
        !isset($_POST['item-id']) ||
        !isset($_POST['item-name']) ||
        !isset($_POST['item-price']) ||
        !isset($_POST['item-cat-id']) ||
        !isset($_POST['note']) ||
        !isset($_POST['qty']) ||
        !isset($_POST['date']) ||
        !isset($_POST['coffee'])
    )
    {
        $keys = array_keys($_POST);
        error("Plese, input all parameters!", 400, $keys);
    }

    $item_id = $_POST['item-id'];
    $qty = $_POST['qty'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $item_name = $_POST['item-name'];
    $item_price = $_POST['item-price'];
    $item_cat_id = $_POST['item-cat-id'];
    if (!is_numeric($qty) || !is_numeric($item_price) || !is_numeric($item_id)) {
        error("Invalid parameter values!\nMissing int value");
    }
    // do some validation
    if ($item_id == -1) {
        // do some validation
        $item_id = addNewItem($item_name, $item_price, $item_cat_id);
    } else {
        $selected_item = getItem($item_id);
        if ($selected_item['name'] != $item_name ||
            $selected_item['price'] != $item_price ||
            $selected_item['cat-id'] != $item_cat_id)
        {
            $item_id = addNewItem($item_name, $item_price, $item_cat_id);
            noti("Item added because the selected one doesn't match with the input values");
            LogConsole(implode(',', getItem($item_id)));
        }
        // if the item id not equal the request params
    }
    // actual inserting data
    $id_added = addNewRecord($item_id, $qty, $date, $note);
    if ($id_added === -1) {
        error("Error addding your record", 400, $_POST);
    } else {
        redirect("./insert.php");
    }
}

function _income() : void
{
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $label = $_POST['label'];
    // do validations
    if (!is_numeric($amount)) {
        error("Insert a numeric value for amount");
    }
    if (addIncome($label, $amount, $date, $note)) {
        apiResponse(['message' => 'Success!']);
    } else {
        error("Unknown error occurred", 400, $_POST);
    }
}
