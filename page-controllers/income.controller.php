<?php

    // echo ROOT_DIR;
    // that line caused button to large and ugly
// controller
function list_(mysqli $conn): void
{
    $income_list = listIncomes($conn);
    $data = [
        'query' => '',
        'incomes' => $income_list
    ];
    view("income/list", $data);
    return;
}

function edit(mysqli $conn): void
{
    $id = $_GET['id'];
    $income = getIncome($id, $conn);
    if (is_null($income)) {
        view("404");
    }
    $total_income = getTotalIncome($conn);
    $form_action = 'api/update';
    $income_date = $income['date'];
    $income_amount = $income['amount'];
    $income_label = $income['label'];
    $income_note = $income['note'];
    $data = [
        'total_income' => $total_income,
        'form_action' => $form_action,
        'income_date' => $income_date,
        'income_amount' => $income_amount,
        'income_label' => $income_label,
        'income_note' => $income_note,
        'update' => true,
        'id' => $id
    ];
    view("income/form", $data);
}

function add(mysqli $conn): void
{
    $total_income = getTotalIncome($conn);
    $form_action = 'api/add';
    $income_date = date("Y-m-d");
    $income_amount = 500;
    $income_label = '';
    $income_note = '';
    $data = [
        'total_income' => $total_income,
        'form_action' => $form_action,
        'income_date' => $income_date,
        'income_amount' => $income_amount,
        'income_label' => $income_label,
        'income_note' => $income_note,
        'update' => false
    ];
    view("income/form", $data);
}