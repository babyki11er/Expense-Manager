<?php

// controller
// getting user defined values
$conn = connectMysql();
$items = listItems($conn);
$categories = listCategories($conn);
$qty = 1;
$note = '';
$item_id = -1;
$item_name = '';
$item_price = 50;
$cat_id = db_SelectOne($conn, CATEGORY, ['name' => 'None'], 'id')['id'];
$update = false;
$form_link = "./api/add";

$date = _ssGet('insert-date', date('Y-m-d'));

if (isset($_GET['update']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $record_to_update = getRecord($conn, $id);
    if (!is_null($record_to_update)) {
        $update = true;
        $note = $record_to_update['note'];
        $date = $record_to_update['date'];
        $qty = $record_to_update['qty'];
        $item_id = $record_to_update['item_id'];
        $item_name = $record_to_update['item_name'];
        $item_price = $record_to_update['item_price'];
        $cat_id = $record_to_update['cat_id'];
        $form_link = "./api/update";
    }
}
?>
