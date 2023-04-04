<?php
/*
    Variables:
        $rate
        $no_days
        $banner     string
        $month_nav  array with info for monthly navigation links
*/
?>
<div class="container-sm">

    <div class=" mt-5">
        <?php foreach ($month_nav as $m_nav) : ?>
            <a href="<?= $m_nav['href'] ?>" class="<?= $m_nav['class'] ?>">
                <?= $m_nav['label']; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class=" p-2 ">
        Excluding // Filters here
        <!-- will save them in session variables for later, yellow -->
    </div>
    <form method="get" id="calc-form">
    </form>

    <table class=" table table-primary mt-4">
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
</div>