<?php

$conn = connectMysql();
$link_form = './api/add';
$form_label = 'Add Item';
$update = false;
$item_category_id = db_SelectOne($conn, CATEGORY, ['name' => 'None'], 'id')['id'];

if (isset($_GET['update'])) {
    $id_to_update = $_GET['id'];
    $item_to_update = getItemById($id_to_update, $conn);
    if (empty($item_to_update)) {
        echo "<h4>Item you are trying to edit is either deleted or does not exist.</h4>";
    } else {
        $update = true;
        $link_form = './api/update';
        $item_name = $item_to_update['name'];
        $item_price = $item_to_update['price'];
        $item_category_id = $item_to_update['cat_id'];
        $form_label = 'Update Item';
    }
}

// displaying exististing items
// setting the variable to use for ordering the records
if (isset($_GET['order'])) {
    setOrder(ITEM, $_GET['order']);
}

$active_items = listItems($conn);
?>