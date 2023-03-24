
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
                $update_link = "./item?update&id=$id";
                ?>
                <tr>
                    <td><?= $item_name_diplay; ?></td>
                    <td><?= displayMoney($item_price); ?></td>
                    <td><?= $item_category; ?></td>
                    <td>
                        <a href="<?= $update_link; ?>" class=" btn btn-primary">Update</a>
                        <form action="/api/archive" method="post" class=" d-inline-block">
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

