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

        <label for="" class=" form-label">
            Amount
        </label>

        <input name="amount" type="number" id="" placeholder="Insert Pirce" value="0" class=" form-control" />
        <label for="" class=" form-label">
            Label
        </label>
        <input name="label" type="text" id="" placeholder="Salary" class=" form-control" />
        <div class="mb-3">
            <label class=" form-label" for="date">Date</label>
            <input class="form-control" type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" for="note">Addional Note</label>
            <textarea class=" form-control" name="note" id=""></textarea>
        </div>
        <button class=" btn btn-dark w-100" name="coffee">
            Submit
        </button>
    </form>
</div>

<?php require_once "./footer.php" ?>
