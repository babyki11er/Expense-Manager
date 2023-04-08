<?php
// controller
function list_(mysqli $conn): void
{
    if (isset($_GET['order'])) {
        setOrder(RECORD, $_GET['order']);
    }
    $current_month = date('m');
    if (isset($_GET['m']) && is_numeric($_GET['m']) && $_GET['m'] != $current_month) {
        $current_month = $_GET['m'];
    }
    // $active_records = listRecords($conn, $current_month);
    $daily_records = make_daily_records($conn, $current_month);
    // make months nav elements
    // yellow, month_nav deserves its own function, all it does is return this nav elements with attributes
    $months = getMonths($conn);
    $months = array_reverse($months);
    $month_nav = array_map(function ($m) use ($current_month) {
        $elm = [
            'label' => MONTH_NAMES[$m],
            'class' => 'btn btn-success mb-2 me-3 ',
            'href' => route("records", ['m' => $m])
        ];

        if ($m == $current_month) {
            $elm['class'] = 'btn mb-2 me-3 btn-primary';
        }

        return $elm;
    }, $months);
    $data = [
        'daily_records' => $daily_records,
        'month_nav' => $month_nav
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