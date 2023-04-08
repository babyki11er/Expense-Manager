<?php
/*
    Variables:
        $active_records     associative array
*/
?>
<div class="container">
    <div class=" mt-5">
        <?php foreach ($month_nav as $m_nav) : ?>
            <a href="<?= $m_nav['href'] ?>" class="<?= $m_nav['class'] ?>">
                <?= $m_nav['label']; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class=" d-flex justify-content-between mt-3">
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
                <a href="?order=date">
                    Day
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
                <a href="?order=id">
                    #
                </a>
            </th>
        </thead>
        <tbody>
            <?php
            // be aware of two for each!
            foreach ($daily_records as $record_info) :
                foreach($record_info['data'] as $record):
                $id = $record['id'];
                $update_url = route("record/edit", ['id' => $id]);
            ?>
                <tr>
                    <td>
                        <?= "<strong><{$record['day']}></strong> {$record['day_name']}" ?>
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
                        <?= $record['id'] ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td>
                    </td>
                    <td class=" fw-bold text-end">
                        Total Cost
                    </td>
                    <td colspan="2" class=" fw-bolder text-center">
                        <?= displayMoney($record_info['total_cost']) ?>
                    </td>
                    <td colspan="4">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>