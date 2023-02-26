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
    <form action="./api/add-api.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="selected" value="record">
        <input type="hidden" name="item_id" id="item_id">
        <table class="mt-3 container">
            <thead>
                <th>Item</th>
                <th>Price</th>
                <th>Category</th>
                <th>Qty</th>
                <th>Note</th>
                <th>Date</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input list="suggestionMenu" type="text" name="item_name" id="item_name" class=" tea" required autocomplete="off">
                        <datalist id="suggestionMenu">
                            <?php foreach ($items as $item) : ?>
                                <option value="<?= $item['name'] ?>" data-itemId="<?= $item['id'] ?>" class="suggestion"></option>
                            <?php endforeach; ?>
                        </datalist>
                    </td>
                    <td class=" ">
                        <input class="tea" type="number" name="item_price" value="100" id="item_price" required min="0" max="600000">
                    </td>
                    <td>
                        <select name="item_cat_id" id="item_category" class="">
                            <option value="0">None</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['id']; ?>"><?= ucfirst($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="qty" id="" value="1" class=" tea" min="0" max="199">
                    </td>
                    <td>
                        <textarea class=" tea" name="note" id=""></textarea>
                    </td>
                    <!-- <td>
                        <input class=" tea" type="file" name="pic" id="" accept="image/jpeg, image/png">
                    </td> -->
                    <td>
                        <input class="tea" type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class=" w-50">
                        <button class=" btn btn-success" name="coffee">
                            Submit
                        </button>
                    </td>
                </tr>
            </tbody>
    </form>
    </table>
</div>
<!-- <script src="./js/functions.js"></script> -->
<script src="./js/insert.js">
</script>
<?php
require_once "./footer.php";
?>