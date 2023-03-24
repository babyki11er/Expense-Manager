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

?>