<?php
// TODOs: test changing .value to setAttribute('value', $s);
// BUG: item_id returning 1
// Bug: date not remembering chosen date


require_once "./header.php";

// getting user defined values
$conn = connectMysql();
$items = listItems($conn);
$categories = listCategories($conn);
?>
<div class=" p-3">
    <h4>Insert record</h4>
    <form action="./api/add-api.php" method="post" enctype="multipart/form-data" class=" container-sm mt-5">
        <input type="hidden" name="selected" value="record">
        <input type="hidden" name="item_id" id="item_id" value="-1">

        <!-- FORM ITEM PART -->
        <div class="mb-3">
            <div class="input-group" id="dd">
                <span class=" input-group-text">
                    Item
                </span>
                <input list="suggestionMenu" type="text" name="item_name" id="item_name" class=" form-control" required autocomplete="off">
                <datalist id="suggestionMenu">
                    <?php foreach ($items as $item) : ?>
                        <option value="<?= $item['name'] ?>" data-itemId="<?= $item['id'] ?>" class="suggestion"></option>
                    <?php endforeach; ?>
                </datalist>
                <span class=" input-group-text">Qty:</span>
                <input type="number" name="qty" value="1" class=" form-control">
                <span class=" input-group-text">Date</span>
                <input class="form-control" type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="mb-3">
            <div class=" input-group">
                <span class=" input-group-text">
                    Price
                </span>
                <input class="form-control" type="number" name="item_price" id="item_price" required step="50" value="50">
                <span class=" input-group-text">
                    Category
                </span>
                <select name="item_cat_id" id="item_category" class=" form-select">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id']; ?>"><?= ucfirst($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mb-3">

            <label for="" class=" form-label">
                Note
            </label>
            <textarea class=" form-control" name="note" id=""></textarea>
        </div>
        <div class=" input-group w-50">
        </div>
        <button class=" btn btn-success w-100" name="coffee">
            Submit
        </button>
    </form>
</div>
<!-- <script src="./js/functions.js"></script> -->
<script src="./js/insert.js">
</script>
<?php
require_once "./footer.php";
?>