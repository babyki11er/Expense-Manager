<?php
require_once '../globals.php';
require_once ROOT_DIR . '/functions/functions.php';
    $conn = connectMysql();
    $current_day = (int) date("d"); // later give option to choose
    $current_month = (int) date("m");
    $total_income = getTotalIncome($conn);
    $total_outcome = getTotalOutcome($conn, $current_month);
    echo $total_outcome;
    $months = getMonths($conn);
    $r = array_map(function ($elm) {
        return $elm['Month'];
    }, $months);
    print_r($r);
?>