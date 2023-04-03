<?php
// controller
function main(): void
{
    $conn = connectMysql();
    $current_day = (int) date("d"); // later give option to choose
    $current_month = (int) date("m");
    $current_month_name = date('M');
    $total_income = getTotalIncome($conn);
    $total_outcome = getTotalOutcome($conn, $current_month);
    $remaining_amount = $total_income - $total_outcome;
    $average_rate = $total_outcome / $current_day;
    // $spare = 0; for later use

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
        $calc_rate = $average_rate;
        $calc_days_left = ceil($remaining_amount / $calc_rate);
    }
    $banner = "Having spent " . displayMoney($total_outcome)
        . " MMKs this month within $current_day days, your average rate is " . displayMoney($average_rate)
        . " MMKs per day";

    $data = [
        "rate" => $calc_rate,
        "no_days" => $calc_days_left,
        "banner" => $banner,
        "current_month_name" => $current_month_name
    ];
    view("index", $data);
    return;
}
?>