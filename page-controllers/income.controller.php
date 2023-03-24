<?php

// controller
$conn = connectMysql();
$incomes = listIncomes($conn);
$update = false;
$form_link = './api/add';
$income_amount = 500;

if (isset($_GET['update'])) {
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

?>