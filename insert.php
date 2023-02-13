<?php
// TODOs: test changing .value to setAttribute('value', $s);
// BUG: item_id returning 1
// Bug: date not remembering chosen date


require_once "./header.php";

// getting user defined values
$items = getItemsPublic();
$categories = listCategories();
?>
<div class=" p-3">
    <h4>Insert record</h4>
    <form action="./api/add-api.php" method="post" enctype="multipart/form-data" class=" container-sm mt-5">
        <input type="hidden" name="attr" value="record">

        <!-- FORM ITEM PART -->
        <label class=" form-label" for="">
            ITEM
        </label>
        <div class="mb-3">
            <select name="item-id" id="selected-item" class=" form-select mb-3">
                <option value="-1" selected="true">
                    custom
                </option>
                <?php foreach ($items as $id => $item) : ?>
                    <option value="<?= $id; ?>">
                        <?= ucfirst($item['name']); ?>
                    </option>
                <?php endforeach; ?>
                <!-- <option value="fee">Fee</option>
                <option value="replace">Renew</option> -->
            </select>
            <label class=" form-label" for="">
                Name
            </label>
            <div class="input-group">
                <input type="text" name="item-name" id="item-name" class=" form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label class=" form-label">Price</label>
            <div class=" input-group">
                <input class="form-control" type="number" name="item-price" id="item-price" required>
                <span class=" input-group-text">Qty:</span>
                <input type="number" name="qty" id="" value="1" class=" form-control">
            </div>
        </div>


        <!-- FORM CATEGORY PART -->
        <!-- Category -->
        <div class="mb-3">
            <label class=" form-label" for="category">Category</label>
            <select name="item-cat_id" id="item-category" class=" form-select">
                <?php foreach ($categories as $cat_id => $cat_str) : ?>
                    <option value="<?= $cat_id; ?>"><?= ucfirst($cat_str); ?></option>
                <?php endforeach; ?>
                <!-- <option value="fee">Fee</option>
                <option value="replace">Renew</option> -->
            </select>
        </div>

        <div class="mb-3">
            <label class=" form-label" for="date">Date</label>
            <input class="form-control" type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" for="pic">Picture</label>
            <input class=" form-control" type="file" name="pic" id="" accept="image/jpeg, image/png">
        </div>

        <div class="mb-3">
            <label class="form-label" for="note">Addional Note</label>
            <textarea class=" form-control" name="note" id=""></textarea>
        </div>
        <button class=" btn btn-primary w-100" name="coffee">
            Submit
        </button>
    </form>
</div>
<script src="./js/insert.js">
</script>
<?php
require_once "./footer.php";
?>