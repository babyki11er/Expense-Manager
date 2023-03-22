<?php
// require_once ROOT_DIR . "/functions/functions.php";

function category(mysqli $conn): void
{
    $id = (int)$_POST['id'];
    $value = $_POST['value'];
    if (updateCategory($id, $value, $conn)) {
        back_to_referer("Category updated successfully!");
    }
    error("Internal DB Error", 500);
}

function item(mysqli $conn): void
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $cat_id = $_POST['cat_id'];
    if (isset($_POST['overwrite'])) {
        if (updateItem($id, $name, $price, $cat_id, $conn)) {
            back_to_referer("Item has been updated including past records!");
        }
    }
    else {
        archiveItem($id, $conn);
        if (addNewItem($name, $price, $cat_id, $conn) >= 0) {
            back_to_referer("Item has been updated but past records will still have the old item");
        }
    }
    error("Internal DB Error", 500, $_POST);
}

function record(mysqli $conn): void
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
        error("Plese, input all parameters!", 400, $keys);
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
        // saving the date in session
        _ssSet('insert-date', $date);
        back_to_referer("Record #$id updated successfully!");
    }
    error("Internel DB Error", 500);
}

function income(mysqli $conn): void
{
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $label = $_POST['label'];
    if (updateIncome($id, $amount, $label, $date, $note, $conn)) {
        back_to_referer("Income updated successfully!");
    }
    error("Internal DB Error", 500);
}