<?php
/* Variables:
        total_income    int
        form_action     string
        $income_date    string
        $income_amount  int
        $income_label   string
        $income_note    string
        $update         boolean
            $id         int

        */
?>
<div class=" container">
    <h4>
        Total Income: <?= $total_income ?>
    </h4>
    <form action="<?= $form_action ?>" method="post" class=" p-4">
        <input type="hidden" name="selected" value="income" />

        <div class="mb-3">
            <label class=" form-label" for="date">Date</label>
            <input class="form-control" type="date" name="date" id="date" value="<?= $income_date; ?>">
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