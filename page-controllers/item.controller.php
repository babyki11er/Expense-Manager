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
    $form_action = route('api/add');
    $default_cat_id = db_SelectOne($conn, CATEGORY, ['name' => 'None'], 'id')['id'];
    $default_item = _makeItem('', 50, $default_cat_id);
    $categories = listCategories($conn);
    $data = [
        'categories' => $categories,
        'update' => false,
        'item' => $default_item,
        'form_action' => $form_action
    ];
    view("item/form", $data);
}

function edit(mysqli $conn): void
{
    $id_to_update = $_GET['id'];
    $item_to_update = getItemById($id_to_update, $conn);
    if (empty($item_to_update)) {
        view("404");
    }
    $form_action = route('api/update');
    $categories = listCategories($conn);
    $data = [
        'form_action' => $form_action,
        'categories' => $categories,
        'item' => $item_to_update,
        'update' => true
    ];
    view("item/form", $data);
}
