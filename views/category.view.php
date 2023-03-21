<?php require_once TEMPLATE_DIR . "header.php" ?>

<?php

if (isset($_GET['order'])) {
    setOrder(CATEGORY, $_GET['order']);
}

$conn = connectMysql();
$categories = listCategories($conn);
$update = False;
$form_action_link = './api/add';
$form_label = "New Category";
if (isset($_GET['update'])) {
    $id = $_GET['id'];
    $categroy_to_update = getCategoryName($id, $conn);
    if (is_null($categroy_to_update)) {
        echo "<h4>Category you are trying to edit is either deleted or does not exist.</h4>";
    } else {
        $form_action_link = './api/update';
        $update = True;
        $form_label = "Update Category";
        $button_label = "Update";
    }
}
?>
<!-- ADD NEW CATEGORY FORM -->
<div class=" w-50">
    <form action="<?= $form_action_link; ?>" method="post" class=" p-4">
        <div class="mb-2">
            <label for="" class=" form-label">
                <?= $form_label; ?>
            </label>
        </div>
        <div class=" input-group" id="dd">
            <input name="value" type="text" value="<?= $categroy_to_update; ?>" placeholder="Enter new category" class=" form-control" autofocus />
            <?php if ($update) : ?>
                <input type="hidden" name="id" value="<?= $id ?>">
                <button class="btn btn-primary col-4">
                    Update
                </button>
            <?php else : ?>
                <button class="btn btn-dark col-4">
                    Add
                </button>
            <?php endif; ?>
        </div>
        <input type="hidden" name="selected" value="category">
    </form>
</div>
<!-- DISPLAY EXISTING CATEGORIES -->
<?php
?>
<div class=" m-4">
    <h4>Categories:</h4>
    <?php if (empty($categories)) : ?>
        <h3>EMPTY</h3>
    <?php else : ?>
        <div class=" row">
            <?php foreach ($categories as $category) :
                $id = $category['id'];
                $cat = $category['name'];
                // $archive_link = "./api/archive?selected=category&id=$id";
                $rename_link = "./category?update&id=$id";
            ?>
                <?php if ($cat === 'None') continue; ?>
                <div class=" mb-3">
                    <label class=" col-2 col-md-4" id="<?= "label-$id"; ?>">
                        <?= $cat; ?>
                    </label>
                    <a href="<?= $rename_link ?>" class=" btn btn-primary col-lg-1 col-md-2">
                        Rename
                    </a>
                    <form action="/api/archive" method="post" class=" d-inline-block col-lg-1 col-md-2">
                        <input type="hidden" name="selected" value="category">
                        <input type="hidden" name="id" value="<?= $id?>">
                        <button class=" btn btn btn-warning" name="del">
                            Archive
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<script src="./js/functions.js">
</script>
<script src="./js/_category.js">
</script>
<?php require_once TEMPLATE_DIR . "footer.php" ?>