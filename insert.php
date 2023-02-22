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
        <input type="hidden" name="item_id" id="item_id">

        <!-- FORM ITEM PART -->
        <label class=" form-label" for="">
            ITEM
        </label>
        <div class="mb-3">
            <label class=" form-label" for="">
                Name
            </label>
            <div class="input-group" id="dd">
                <input list="suggestionMenu" type="text" name="item_name" id="item_name" class=" form-control" required autocomplete="off">
                <datalist id="suggestionMenu">
                    <?php foreach($items as $item): ?>
                        <option value="<?= $item['name'] ?>" data-itemId="<?= $item['id'] ?>" class="suggestion"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
        </div>
        <div class="mb-3">
            <label class=" form-label">Price</label>
            <div class=" input-group">
                <input class="form-control" type="number" name="item_price" id="item_price" required>
                <span class=" input-group-text">Qty:</span>
                <input type="number" name="qty" id="" value="1" class=" form-control">
            </div>
        </div>


        <!-- FORM CATEGORY PART -->
        <!-- Category -->
        <div class="mb-3">
            <label class=" form-label" for="category">Category</label>
            <select name="item_cat_id" id="item_category" class=" form-select">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['id']; ?>"><?= ucfirst($category['name']); ?></option>
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