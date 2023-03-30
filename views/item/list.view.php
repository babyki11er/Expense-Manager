<?php
/*
    Variables:
        $active_items   array
*/

?>
<div class=" d-flex justify-content-between m-4 mt-5">
    <a href="<?= route("item/add"); ?>" class=" btn btn-dark">Add New</a>
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

<div class=" m-4 table-responsive">
    <table class="table table-bordered border-dark table-striped">
        <thead>
            <th>
                <a href="?order=name">
                    Name
                </a>
            </th>
            <th>
                <a href="?order=price">
                    Price
                </a>
            </th>
            <th>
                <a href="?order=cat_id">
                    Category
                </a>
            </th>
            <th class=" table-danger">Update/Archive</th>
        </thead>
        <tbody>
            <?php foreach ($active_items as $item) : ?>
                <?php
                $id = $item['id'];
                $item_name_diplay = displayItem($item);
                $item_price = $item['price'];
                $item_category = $item['cat_str'];
                $update_link = route("item/edit", ['id' => $id]);
                ?>
                <tr>
                    <td><?= $item_name_diplay; ?></td>
                    <td><?= displayMoney($item_price); ?></td>
                    <td><?= $item_category; ?></td>
                    <td>
                        <a href="<?= $update_link; ?>" class=" btn btn-primary">Update</a>
                        <form action="<?= route("api/archive") ?>" method="post" class=" d-inline-block">
                            <input type="hidden" name="selected" value="item">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button class=" btn btn btn-warning">
                                Archive
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>