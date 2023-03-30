<?php

function list_(mysqli $conn): void
{
    // displaying exististing items
    // setting the variable to use for ordering the records
    if (isset($_GET['order'])) {
        setOrder(ITEM, $_GET['order']);
    }

    $active_items = listItems($conn);
    $data = [
        'active_items' => $active_items
    ];
    view("item/list", $data);
}

function add(mysqli $conn): void
{
    $link_form = './api/add';
    $form_label = 'Add Item';
    $update = false;
    $item_category_id = db_SelectOne($conn, CATEGORY, ['name' => 'None'], 'id')['id'];
}

function edit(mysqli $conn): void
{
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
