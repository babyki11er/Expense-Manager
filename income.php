<?php
require_once "./header.php";
$conn = connectMysql();
?>
<!-- ADD NEW INCOME FORM -->
<div class=" container">
    <h4>
        Total Income: <?= getTotalIncome($conn); ?>
    </h4>
    <form action="./api/add-api.php" method="post" class=" p-4">
        <input type="hidden" name="selected" value="income" />

        <div class="mb-3">
            <label class=" form-label" for="date">Date</label>
            <input class="form-control" type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="input-group">
            <input name="amount" type="number" id="" placeholder="Enter the amount" class=" form-control" />
            <input name="label" type="text" id="" placeholder="Label" class=" form-control" />
        </div>

        <div class="mb-3">
            <label class="form-label" for="note">Addional Note</label>
            <textarea class=" form-control" name="note" id=""></textarea>
        </div>
        <button class=" btn btn-success w-100" name="income">
            Submit
        </button>
    </form>
</div>

<!-- Display history -->
<table class=" table table-success table-bordered border-2 mt-3 container">
    <thead>
        <th>Date</th>
        <th>Amount</th>
        <th>Label</th>
        <th>Note</th>
    </thead>
    <tbody>

    </tbody>
</table>
<?php require_once "./footer.php" ?>
