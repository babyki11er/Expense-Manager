<?php
require_once "./header.php";
$conn = connectMysql();
$link_form = './api/add-api.php';
$form_label = 'Add Item';
$update = false;
$item_category_id = db_SelectOne($conn, CATEGORY, ['name' => 'None'], 'id')['id'];

if (isset($_GET['update'])) {
    $id_to_update = $_GET['id'];
    $item_to_update = getItemById($id_to_update, $conn);
    if (empty($item_to_update)) {
        echo "<h4>Item you are trying to edit is either deleted or does not exist.</h4>";
    } else {
        $update = true;
        $link_form = './api/update-api.php';
        $item_name = $item_to_update['name'];
        $item_price = $item_to_update['price'];
        $item_category_id = $item_to_update['cat_id'];
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
            <span class="input-group-text">Name</span>
            <input name="name" type="text" id="" placeholder="Name for new Item" class=" form-control" required value="<?= $item_name ?>" />
            <span class="input-group-text">Price</span>
            <input name="price" type="number" id="" placeholder="Insert Pirce" value="<?= $item_price; ?>" class=" form-control" step="50" />
            <span class="input-group-text">Category</span>
            <select name="cat_id" id="" class=" form-select">

                <?php
                $categories = listCategories($conn);
                foreach ($categories as $category) :
                    $id = $category['id'];
                    $cat = $category['name'];
                ?>
                    <option value="<?= $id ?>" <?php if ($id === $item_category_id) echo "selected" ?>>
                        <?= $cat ?>
                    </option>
                <?php endforeach ?>

            </select>
        </div>
        <?php if ($update) : ?>
            <input type="hidden" name="id" value="<?= $id_to_update ?>">
            <div class="form-check">
                <label for="overwrite" class=" form-check-label">Apply on past records</label>
                <input type="checkbox" name="overwrite" id="overwrite" class=" form-check-input" checked>
            </div>
            <button class="btn btn-primary form-control">
                Update
            </button>
        <?php else : ?>
            <button class=" btn btn-dark form-control">
                Add
            </button>
        <?php endif; ?>
    </form>
</div>


<!-- DISPLAY ITEMS -->
<?php
// setting the variable to use for ordering the records
if (isset($_GET['order'])) {
    setOrder(ITEM, $_GET['order']);
}

// yellow, i am not sure if i could avoid having to pass the order for every call, since the value is stored in session, why can't i just directly get the value from the list function?
$active_items = listItems($conn);
?>
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
                $update_link = "./item.php?update&id=$id";
                $archive_link = "./api/archive-api.php?selected=item&id=$id&del";
                ?>
                <tr>
                    <td><?= $item_name_diplay; ?></td>
                    <td><?= displayMoney($item_price); ?></td>
                    <td><?= $item_category; ?></td>
                    <td>
                        <a href="<?= $update_link; ?>" class=" btn btn-primary">Update</a>
                        <a href="<?= $archive_link; ?>" class=" btn btn-warning">Archive</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once "./footer.php" ?>