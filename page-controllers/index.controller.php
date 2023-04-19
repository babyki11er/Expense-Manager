<?php
// controller
function main(): void
{
    // red! what is this code doing here? page related controller just don't connect to database directly
    $conn = connectMysql();
    $current_day = (int) date("d"); // later give option to choose
    $current_month = (int) date("m");
    if (isset($_GET['m']) && is_numeric($_GET['m']) && $_GET['m'] != $current_month) {
        $current_month = $_GET['m'];
        $current_day = 30;
    }
    $total_outcome = getTotalOutcome($conn, $current_month);
    $remaining_amount = getRemainingBalance($conn);
    $average_rate = $total_outcome / $current_day;
    $banner = "Having spent " . displayMoney($total_outcome)
        . " MMKs this month within $current_day days, your average rate is " . displayMoney($average_rate)
        . " MMKs per day";

    // $spare = 0; for later use

    // calculation on user given rate and day
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
    // make months nav elements
    $months = getMonths($conn);
    $months = array_reverse($months);
    $month_nav = array_map(function ($m) use ($current_month) {
        $elm = [
            'label' => MONTH_NAMES[$m],
            'class' => 'btn btn-success mb-2 me-3 ',
            'href' => route("", ['m' => $m])
        ];

        if ($m == $current_month) {
            $elm['class'] = 'btn mb-2 me-3 btn-primary';
        }

        return $elm;
    }, $months);
    $data = [
        "rate" => $calc_rate,
        "no_days" => $calc_days_left,
        "banner" => $banner,
        "month_nav" => $month_nav
    ];
    view("index", $data);
    return;
}
?>