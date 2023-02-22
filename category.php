<?php require_once "./header.php" ?>

<?php
$conn = connectMysql();
$categories = listCategories($conn);
$update = False;
$form_action_link = './api/add-api.php';
$form_label = "New Category";
$button_label = "Add";
if (isset($_GET['update']))
{
    $id = $_GET['id'];
    $categroy_to_update = getCategoryName($id, $conn);
    if (is_null($categroy_to_update)) {
        echo "<h4>Category you are trying to edit is either deleted or does not exist.</h4>";
    } else {
        $form_action_link = './api/update-api.php';
        $update = True;
        $form_label = "Update Category";
        $button_label = "Update";
    }
}

?>
<!-- ADD NEW CATEGORY FORM -->
<div class=" w-50">
    <form action="<?= $form_action_link; ?>" method="post" class=" p-4">
    <?php if ($update): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>
        <div class="mb-2">
            <label for="" class=" form-label">
                <?= $form_label; ?>
            </label>
        </div>
        <div class=" input-group" id="dd">
            <input name="value" type="text" value="<?= $categroy_to_update; ?>" placeholder="Enter new category" class=" form-control" autofocus />
            <button class="btn btn-success col-4">
                <?= $button_label; ?>
            </button>
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
                $archive_link = "./api/archive-api.php?selected=category&id=$id";
                $rename_link = "./category.php?update&id=$id";
            ?>
                <?php if ($id == 0) continue; ?>
                <div class=" mb-3">
                    <label class=" col-2 col-md-4" id="<?= "label-$id"; ?>">
                        <?= $cat; ?>
                    </label>
                    <a href="<?= $rename_link ?>" class=" btn btn-primary col-lg-1 col-md-2">
                        Rename
                    </a>
                    <a href="<?= $archive_link; ?>" class=" btn btn-warning col-lg-1 col-md-2">Archive</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<script src="./js/functions.js">
</script>
<script src="./js/_category.js">
</script>
<?php require_once "./footer.php" ?>