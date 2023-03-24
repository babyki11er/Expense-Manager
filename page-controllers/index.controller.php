<?php

// controller
$day = (int) date("d");
$total_spent = $total_outcome;
$rate = $total_outcome / $day;
$days_left = $remaining_amount / $rate;
$spare = 0;

if (isset($_GET['given'])) {
    $given = $_GET['given'];
    if ($given == 'rate') {
        $calc_rate = (int) $_GET['given_rate'];
        $calc_days_left = ceil($remaining_amount / $calc_rate);
    } else if ($given == 'days') {
        $calc_days_left = (int) $_GET['given_days'];
        $calc_rate = ceil($remaining_amount / $calc_days_left);
    }
} else {
    $calc_rate = $rate;
    $calc_days_left = ceil($remaining_amount / $calc_rate);
}

?>