<?php require_once "./header.php" ?>

<!-- ADD NEW ITEM FORM -->
<div class=" container">
    <form action="add-api.php" method="post" class=" p-4">
        <input name="attr" type="hidden" value="item" />

        <div class=" input-group mb-3">
            <input name="name" type="text" id="" placeholder="Name for new Item" class=" form-control" required />

            <input name="price" type="number" id="" placeholder="Insert Pirce" value="0" class=" form-control" />
        </div>
        <!-- displaying categories to choose for the new item -->
        <select name="cat-id" id="" class=" form-select mb-3">
            <option value="0" selected>
                None
            </option>
            <?php
            $categories = listCategories();
            asort($categories);
            foreach ($categories as $id => $cat) : ?>
                <?php if ($id === 0) continue; ?>
                <option value="<?= $id ?>">
                    <?= ucfirst($cat); ?>
                </option>
            <?php endforeach ?>
        </select>
        <button class="btn btn-dark form-control">
            Add
        </button>
    </form>
</div>


<!-- DISPLAY ITEMS -->
<?php
$active_items = getItemsPublic();
?>
<div class=" m-4 table-responsive">
    <table class="table table-bordered border-dark table-striped">
        <thead>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th class=" table-danger">Edit/Archive</th>
        </thead>
        <tbody>
            <?php foreach ($active_items as $id => $item) : ?>
                <?php
                $item_name = $item['name'];
                $item_price = $item['price'];
                $item_category = $item['cat-str'];
                $archive_link = "./api/archive-api.php?attr=item&id=$id&del";
                $wipe_link = "wipe-api.php?attr=item&id=$id&wipe";
                ?>
                <tr>
                    <td><?= $item_name; ?></td>
                    <td><?= $item_price; ?></td>
                    <td><?= $item_category; ?></td>
                    <td>
                        <a href="<?= $archive_link; ?>" class=" btn btn-warning">Archive</a>
                        <a href="#" class=" btn btn-danger">Wipe Related Data</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once "./footer.php" ?>