<?php
// controller
function list_(mysqli $conn): void
{
    if (isset($_GET['order'])) {
        setOrder(RECORD, $_GET['order']);
    }
    $active_records = listRecords($conn);
    $data = [
        'active_records' => $active_records
    ];
    view("record/list", $data);
}

function add(mysqli $conn): void
{
    $items = listItems($conn);
    $categories = listCategories($conn);
    $cat_id = db_SelectOne($conn, CATEGORY, ['name' => 'None'], 'id')['id'];

    $date = _ssGet('insert-date', date('Y-m-d'));
    $record = _makeRecord(-1, 1, $date, '');
    $record['item_name'] = '';
    $record['item_price'] = 50;
    $record['cost'] = 50;
    $record['cat_str'] = 'None';
    $record['cat_id'] = $cat_id;

    $form_action = route("api/add");
    $data = [
        'items' => $items,
        'categories' => $categories,
        'record' => $record,
        'form_action' => $form_action,
        'update' => false
    ];
    view("record/form", $data);
}

function edit(mysqli $conn): void
{
    // validation
    if (!isset($_GET['id'])) {
        // using a blacklist here, but it makes sense for now i think, don't have much to check really
        redirect(route("record/add"));
    }
    $id = $_GET['id'];
    $record_to_update = getRecord($conn, $id);
    if (is_null($record_to_update)) {
        view("404");
    }
    $items = listItems($conn);
    $categories = listCategories($conn);
    $form_action = route("api/update");
    $data = [
        'items' => $items,
        'categories' => $categories,
        'record' => $record_to_update,
        'form_action' => $form_action,
        'update' => true
    ];
    view("record/form", $data);
}