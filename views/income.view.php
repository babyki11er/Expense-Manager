<!-- ADD NEW INCOME FORM -->
<div class=" container">
    <h4>
        Total Income: <?= getTotalIncome($conn); ?>
    </h4>
    <form action="<?= $form_link ?>" method="post" class=" p-4">
        <input type="hidden" name="selected" value="income" />

        <div class="mb-3">
            <label class=" form-label" for="date">Date</label>
            <input class="form-control" type="date" name="date" id="date" value="<?= isset($income_date) ? $income_date : date('Y-m-d'); ?>">
        </div>

        <div class="input-group">
            <input name="amount" type="number" id="" placeholder="Enter the amount" value="<?= $income_amount ?>" class=" form-control" step="50" />
            <input name="label" type="text" id="" placeholder="Label" value="<?= $income_label ?>" class=" form-control" />
        </div>

        <div class="mb-3">
            <label class="form-label" for="note">Addional Note</label>
            <textarea class=" form-control" name="note" id=""><?= $income_note ?></textarea>
        </div>
        <?php if ($update): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
            <button class=" btn btn-primary w-100" name="income">
                Update
            </button>
        <?php else: ?>
            <button class=" btn btn-dark w-100" name="income">
                Submit
            </button>
        <?php endif; ?>
    </form>
</div>

<!-- Display history -->
<table class=" table table-success table-bordered border-2 mt-3 container">
    <thead>
        <th>Date</th>
        <th>Label</th>
        <th>Amount</th>
        <th>Note</th>
        <th>Update/Delete</th>
    </thead>
    <tbody>
        <?php foreach($incomes as $income) :
            $update_link = "./income?update&id={$income['id']}";
            $delete_link = "./api/del?selected=income&id={$income['id']}&del";
        ?>
            <tr>
                <td>
                    <?= $income['date']; ?>
                </td>
                <td>
                    <?= $income['label']; ?>
                </td>
                <td>
                    <?= $income['amount']; ?>
                </td>
                <td>
                    <?= $income['note']; ?>
                </td>
                <td>
                    <a href="<?= $update_link ?>" class=" btn btn-primary">
                        Update
                    </a>
                    <form action="/api/del" method="post" class=" d-inline-block">
                        <input type="hidden" name="selected" value="income">
                        <input type="hidden" name="id" value="<?= $income['id'] ?>">
                        <button class=" btn btn-sm btn-danger" name="del">
                            Del
                        </button>
                    </form>
                    <!-- <a href="<?= $delete_link ?>" class=" btn btn-danger">
                        Delete
                    </a> -->
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>

