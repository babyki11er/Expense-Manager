<?php
/*
    Variables:
        $rate
        $no_days
        $banner
        $current_month_name
*/
?>
<div class=" d-flex justify-content-between m-4 mt-5">
    <a href="<?= route(""); ?>" class=" btn btn-primary">
        <?= $current_month_name; ?>
    </a>
    <a href="<?= route("", ['m' => 3]); ?>" class=" btn btn-success">
    <!-- hard-coded for now, obviously -->
        3
    </a>
    </form>
</div>
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