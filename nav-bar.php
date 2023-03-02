<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php';
$conn = connectMysql();
$total_income = getTotalIncome($conn);
$total_outcome = getTotalOutcome($conn);
$remaining_amount = $total_income - $total_outcome;
$display = display_money($remaining_amount);

/*
*/
?>
<nav>
    <div class="m-3 ms-2 mb-lg-1">
        <a href="index.php" class=" btn btn-primary btn-sm">HOME</a>
        <a href="income.php" class=" btn btn-success btn-sm">Income</a>
        <a href="item.php" class=" btn btn-sm btn-success">Items</a>
        <a href="category.php" class=" btn btn-sm btn-success">Categories</a>
        <a href="insert.php" class=" btn btn-sm btn-outline-dark">Insert Record</a>
        <a href="records.php" class=" btn btn-sm btn-dark"><?= $display ?> MMK remaining</a>
        <a href="test.php" class=" btn btn-sm btn-dark">TEST</a>
        <!-- <a href="beer.php" class=" btn btn-sm btn-primary">BEER </a> -->
    </div>
</nav>