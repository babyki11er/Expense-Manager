<?php
require_once "./header.php";
$conn = connectMysql();
$link_form = './api/add-api.php';
$form_label = 'Add Item';
$update = false;
if (isset($_GET['update']))
{
    $id_to_update = $_GET['id'];
    $item_to_update = getItem($id_to_update, $conn);
    if (empty($item_to_update)) {
        echo "<h4>Item you are trying to edit is either deleted or does not exist.</h4>";
    } else {
        $update = true;
        $link_form = './api/update-api.php';
        $item_name = $item_to_update['name'];
        $item_price = $item_to_update['price'];
        $item_category = $item_to_update['cat_id'];
        $form_label = 'Update Item';
    }
}
?>

<!-- ADD NEW ITEM FORM -->
<div class=" container">
    <form action="<?= $link_form ?>" method="post" class=" p-4">
        <input name="selected" type="hidden" value="item" />
        <label class="form-label">
            <?= $form_label ?>
        </label>
            <div class=" input-group mb-3">
                <input name="name" type="text" id="" placeholder="Name for new Item" class=" form-control" required value="<?= $item_name?>" />
                <input name="price" type="number" id="" placeholder="Insert Pirce" value="<?= $item_price; ?>" class=" form-control" />
            </div>
        <select name="cat_id" id="" class=" form-select mb-3">

            <?php
            $categories = listCategories($conn);
            foreach ($categories as $category) :
                $id = $category['id'];
                $cat = $category['name'];
            ?>
                <option value="<?= $id ?>" <?php if ($id === $item_category) echo "selected" ?>>
                    <?= $cat ?>
                </option>
            <?php endforeach ?>

        </select>
        <?php if ($update): ?>
            <input type="hidden" name="id" value="<?= $id_to_update ?>">
            <div class="form-check">
                <label for="" class=" form-check-label">Apply on past records</label>
                <input type="checkbox" name="overwrite" id="" class=" form-check-input" checked>
            </div>
            <div class="form-check">
                <label for="" class=" form-check-label">Add as a new version</label>
                <input type="checkbox" name="keep" id="" class=" form-check-input" checked>
            </div>
            <button class="btn btn-primary form-control">
                Update
            </button>
        <?php else: ?>
            <button class=" btn btn-success form-control">
                Add
            </button>
        <?php endif; ?>
    </form>
</div>


<!-- DISPLAY ITEMS -->
<?php
$active_items = listItems($conn);
?>
<div class=" m-4 table-responsive">
    <table class="table table-bordered border-dark table-striped">
        <thead>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th class=" table-danger">Update/Archive</th>
        </thead>
        <tbody>
            <?php foreach ($active_items as $item) : ?>
                <?php
                $id = $item['id'];
                $item_name = $item['name'];
                $item_price = $item['price'];
                $item_category = $item['cat_str'];
                $update_link = "./item.php?update&id=$id";
                $archive_link = "./api/archive-api.php?selected=item&id=$id&del";
                $wipe_link = "wipe-api.php?selected=item&id=$id&wipe";
                ?>
                <tr>
                    <td><?= $item_name; ?></td>
                    <td><?= $item_price; ?></td>
                    <td><?= $item_category; ?></td>
                    <td>
                        <a href="<?= $update_link; ?>" class=" btn btn-primary">Update</a>
                        <a href="<?= $archive_link; ?>" class=" btn btn-warning">Archive</a>
                        <a href="#" class=" btn btn-danger">Wipe Related Data</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once "./footer.php" ?>