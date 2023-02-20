<?php require_once "./header.php" ?>

<!-- ADD NEW CATEGORY FORM -->
<div class=" w-50">
    <form action="./api/add-api.php" method="post" class=" p-4">
        <div class="mb-2">
            <label for="" class=" form-label">
                New Category
            </label>
        </div>
        <div class=" input-group" id="dd">
            <input name="value" type="text" id="search-bar" placeholder="Enter new category" class=" form-control" autofocus />
            <button class="btn btn-primary col-4">Add</button>
        </div>
        <input type="hidden" name="selected" value="category">
    </form>
</div>
<!-- DISPLAY EXISTING CATEGORIES -->
<?php
$conn = connectMysql();
$categories = listCategories($conn);
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
            ?>
                <?php if ($id == 0) continue; ?>
                <div class=" mb-3">
                    <label class=" col-2 col-md-4" id="<?= "label-$id"; ?>">
                        <?= $cat; ?>
                    </label>
                    <button class=" btn btn-warning rename col-lg-1 col-md-2" value="<?= $id; ?>" id="<?= "but-$id" ?>">
                        Rename
                    </button>
                    <a href="<?= $archive_link; ?>" class=" btn btn-dark col-lg-1 col-md-2">Archive</a>
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