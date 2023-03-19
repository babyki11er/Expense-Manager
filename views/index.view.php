<?php
require_once TEMPLATE_DIR . "header.php";

$day = (int) date("d");
$total_spent = $total_outcome;
$rate = $total_outcome / $day;
$days_left = $remaining_amount / $rate;
$spare = 0;

// if (isset($_GET['calc-rate'])) {
//     $calc_days_left = (int) $_GET['given_days'];
//     $calc_rate = ceil($remaining_amount / $calc_days_left);
// } else if (isset($_GET['calc-day'])) {
//     $calc_rate = (int) $_GET['given_rate'];
//     $calc_days_left = ceil($remaining_amount / $calc_rate);
// } else {
//     $calc_rate = 1500;
//     $calc_days_left = ceil($remaining_amount / $calc_rate);
// }
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
<form method="get" id="calc-form">
</form>

<table class=" table table-primary container-sm mt-4">
    <tr>
        <td>
            MMK Per Day
        </td>
        <td>
            <input form="calc-form" type="number" name="given_rate" id="" value="<?= $calc_rate ?>">
        </td>
        <td>
            <button form="calc-form" name="given" value="rate">
                Calc
            </button>
        </td>
    </tr>
    <tr>
        <td>
            No of Days Left:
        </td>
        <td>
            <input form="calc-form" type="number" name="given_days" id="" value="<?= $calc_days_left ?>">
        </td>
        <td>
            <button form="calc-form" name="given" value="days">
                Calc
            </button>
        </td>
    </tr>
</table>
<div class=" container">
    Having spent <?= displayMoney($total_spent) ?> MMKs this month within <?= $day ?> days, your average rate is <?= displayMoney($rate) ?> MMKs per day.
</div>

<?php
require_once TEMPLATE_DIR . "footer.php";
?>