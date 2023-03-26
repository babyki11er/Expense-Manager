<?php

// controller
function list_(mysqli $conn) : void
{
    $income_list = listIncomes($conn);
    $data = [
        'query' => '',
        'incomes' => $income_list
    ];
    view("income/list", $data);
    return;
}

function edit(mysqli $conn) : void
{
    $id = $_GET['id'];
    $income = getIncome($id, $conn);
    if (!is_null($income)) {
        $update = true;
        $form_link = './api/update';
        $income_date = $income['date'];
        $income_amount = $income['amount'];
        $income_label = $income['label'];
        $income_note = $income['note'];
    }
}

function add(mysqli $conn) : void
{
    $form_link = './api/add';
    $income_amount = 500;
}
?>