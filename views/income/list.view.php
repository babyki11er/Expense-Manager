<?php
/* Variables:
        $query      string
        $incomes   array
*/

?>
<div class="container">

    <h1>Incomes</h1>

    <div class=" d-flex justify-content-between mb-3">
        <a href="" class=" btn btn-outline-dark">Add New</a>
        <form action="" method="get">
            <div class=" input-group">
                <!-- yellow -->
                <input type="text" name="q" value="" class=" form-control">
                <?php if (!empty($query)) : ?>
                    <a href="" class=" btn btn-danger">
                        Del
                    </a>
                <?php endif; ?>
                <button class=" btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <table class=" table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Label</th>
                <th>Amount</th>
                <th>Note</th>
                <th>Control</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($incomes as $income) : ?>
                <tr>
                    <td>
                        <?= $income['date']; ?>
                    </td>
                    <td>
                        <?= $income['label']; ?>
                    </td>
                    <td>
                        <?= displayMoney($income['amount']); ?>
                    </td>
                    <td>
                        <?= $income['note']; ?>
                    </td>
                    <td>
                        <a href="#" class=" btn btn-sm btn-outline-info">
                            Edit
                        </a>
                        <form action="/api/del" class=" d-inline-block" method="post">
                            <input type="hidden" name="id" value="<?= $income['id'] ?>">
                            <input type="hidden" name="selected" value="income">
                            <button class=" btn btn-sm btn-outline-danger" name="del">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>