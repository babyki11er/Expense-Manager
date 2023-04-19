<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php';
// green? this code does not belong in a view file
$conn = connectMysql();
$remaining_amount = getRemainingBalance($conn);
$display = displayMoney($remaining_amount);

if ($current_page == '404') {
    // echo '404 from nav-bar-partial';
    return;
}
/*
using a key/value pair because if else conditionals are ugly and unprofessional
*/
$butt_colors = [
    "index" => "btn-primary",
    "income" => "btn-primary",
    "item" => "btn-primary",
    "category" => "btn-primary",
    "insert-record" => "btn-primary",
];

$butt_colors[$current_page] = "btn-warning";

?>
<nav>
    <div class="m-3 ms-2 mb-lg-1">
        <a href="<?= route(""); ?>" class=" btn <?= $butt_colors['index'] ?> btn-sm">HOME</a>
        <a href="<?= route("incomes"); ?>" class=" btn <?= $butt_colors['income'] ?> btn-sm">Income</a>
        <a href="<?= route("items"); ?>" class=" btn btn-sm <?= $butt_colors['item'] ?>">Items</a>
        <a href="<?= route("categories"); ?>" class=" btn btn-sm <?= $butt_colors['category'] ?>">Categories</a>
        <a href="<?= route("record/add"); ?>" class=" btn btn-sm <?= $butt_colors['insert-record'] ?>">Insert Record</a>
        <a href="<?= route("records"); ?>" class=" btn btn-sm btn-dark"><?= $display ?> MMK remaining</a>
        <a href="<?= route("test"); ?>" class=" btn btn-sm btn-dark">TEST</a>
        <!-- <a href="beer.php" class=" btn btn-sm btn-primary">BEER </a> -->
    </div>
</nav>