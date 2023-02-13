<?php require_once "./header.php" ?>
<?php require_once "./nav-bar.php" ?>

<?php
$active_records = getRecordsPublic();
?>

<table class=" table table-success table-bordered border-2 mt-3 container">
    <thead>
        <th>Date</th>
        <th>Item</th>
        <th>Qty</th>
        <th>Cost</th>
        <th>Category</th>
        <th>Note</th>
        <th>Del/Edit</th>
    </thead>
    <tbody>
        <?php
        foreach ($active_records as $id => $record) :
            $del_url = "api/del-api.php?attr=record&del&id=$id";
        ?>
            <tr>
                <td>
                    <?= $record['date'] ?>
                </td>
                <td>
                    <?= $record['item-name'] ?>
                </td>
                <td>
                    <?= $record['qty'] ?>
                </td>
                <td>
                    <?= $record['cost'] ?>
                </td>
                <td>
                    <?= $record['category'] ?>
                </td>
                <td>
                    <?= $record['note'] ?>
                </td>
                <td>
                    <a href="<?= $del_url; ?>" class=" btn btn-sm btn-danger">
                        Del
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once "./footer.php"; ?>