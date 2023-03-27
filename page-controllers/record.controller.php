<?php
// controller
function list_(mysqli $conn) : void
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
    $qty = 1;
    $note = '';
    $item_id = -1;
    $item_name = '';
    $item_price = 50;
    $cat_id = db_SelectOne($conn, CATEGORY, ['name' => 'None'], 'id')['id'];
    $form_link = route("api/add");
    $date = _ssGet('insert-date', date('Y-m-d'));
    $data = [
        'items' => $items,
        'categories' => $categories,

        'form_link' => $form_link,
        'item_id' => $item_id,
        'item_name' => $item_name,
        'item_price' => $item_price,
        'cat_id' => $cat_id,
        'qty' => $qty,
        'date' => $date,
        'note' => $note,
        'update' => false
    ];
    view("record/form", $data);
}

function edit(mysqli $conn) : void
{
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

}

?>
