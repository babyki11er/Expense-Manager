<?php require_once "./header.php" ?>
<?php require_once "./nav-bar.php" ?>

<?php
$conn = connectMysql();
$active_records = getRecordsPublic($conn);
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
        foreach ($active_records as $record) :
            $id = $record['id'];
            $del_url = "api/del-api.php?attr=record&del&id=$id";
        ?>
            <tr>
                <td>
                    <?= $record['date'] ?>
                </td>
                <td>
                    <?= $record['item_name'] ?>
                </td>
                <td>
                    <?= $record['qty'] ?>
                </td>
                <td>
                    <?= $record['cost'] ?>
                </td>
                <td>
                    <?= $record['cat_str'] ?>
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