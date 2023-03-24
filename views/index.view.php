<?php
/*
    Variables:
        $rate
        $no_days
        $banner
*/
?>
<form method="get" id="calc-form">
</form>

<table class=" table table-primary container-sm mt-4">
    <tr>
        <td>
            MMK Per Day
        </td>
        <td>
            <input form="calc-form" type="number" name="given_rate" id="" value="<?= $rate ?>">
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
            <input form="calc-form" type="number" name="given_days" id="" value="<?= $no_days ?>">
        </td>
        <td>
            <button form="calc-form" name="given" value="days">
                Calc
            </button>
        </td>
    </tr>
</table>
<div class=" container">
    <?= $banner; ?>
</div>