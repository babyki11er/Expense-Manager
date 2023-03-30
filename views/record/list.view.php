<?php
/*
    Variables:
        $active_records     associative array
*/
?>
<div class="container">

    <div class=" d-flex justify-content-between mt-5">
        <a href="<?= route("record/add"); ?>" class=" btn btn-dark">Add New Record</a>
        <form action="" method="get">
            <div class=" input-group">
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

    <table class=" table table-success table-bordered mt-3">
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
                $update_url = route("record/edit", ['id' => $id]);
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
                        <!-- $del_url = "api/del?selected=record&del&id=$id"; -->
                        <form action="/api/del" method="post" class=" d-inline-block">
                            <input type="hidden" name="selected" value="record">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button class=" btn btn-sm btn-danger" name="del">
                                Del
                            </button>
                        </form>
                    </td>
                    <td>
                        <?= $record['date'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>