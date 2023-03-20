<?php
require_once TEMPLATE_DIR . "header.php";
require_once TEMPLATE_DIR . "nav-bar.php";
?>

<?php
$conn = connectMysql();
if (isset($_GET['order'])) {
    setOrder(RECORD, $_GET['order']);
}

$active_records = listRecords($conn);
?>

<table class=" table table-success table-bordered border-2 mt-3 container">
    <thead>
        <th>
            <a href="?order=id">
                #
            </a>
        </th>
        <th>
            <a href="?order=item_id">
                Item
            </a>
        </th>
        <th>
            <a href="?order=qty">
                Qty
            </a>
        </th>
        <th>Cost</th>
        <th>Category</th>
        <th>
            <a href="?order=note">
                Note
            </a>
        </th>
        <th>Del/Edit</th>
        <th>
            <a href="?order=date">
                Date
            </a>
        </th>
    </thead>
    <tbody>
        <?php
        foreach ($active_records as $record) :
            $id = $record['id'];
            $del_url = "api/del?selected=record&del&id=$id";
            $update_url = "insert?update&selected=record&id=$id";
        ?>
            <tr>
                <td>
                    <?= $record['id'] ?>
                </td>
                <td>
                    <?= $record['item_name'] ?>
                </td>
                <td>
                    <?= $record['qty'] ?>
                </td>
                <td>
                    <div>
                        <?= displayMoney($record['cost']) ?>
                    </div>
                </td>
                <td>
                    <?= $record['cat_str'] ?>
                </td>
                <td>
                    <?= $record['note'] ?>
                </td>
                <td>
                    <a href="<?= $update_url ?>" class=" btn btn-sm btn-primary">
                        Update
                    </a>
                    <a href="<?= $del_url; ?>" class=" btn btn-sm btn-danger">
                        Del
                    </a>
                </td>
                <td>
                    <?= $record['date'] ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once TEMPLATE_DIR . "footer.php"; ?>