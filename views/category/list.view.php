<?php
/*
    Variables:
        $categories  array
*/
?>
<div class=" d-flex justify-content-between m-4 mt-5">
    <a href="<?= route("category/add"); ?>" class=" btn btn-dark">Add New</a>
</div>

<div class=" m-4">
    <h4>Categories:</h4>
    <?php if (empty($categories)) : ?>
        <h3>EMPTY</h3>
    <?php else : ?>
        <div class=" row">
            <?php foreach ($categories as $category) :
                $id = $category['id'];
                $cat = $category['name'];
                $rename_link = route("category/edit", ['id' => $id]);
            ?>
                <?php if ($cat === 'None') continue; ?>
                <div class=" mb-3">
                    <label class=" col-2 col-md-4" id="<?= "label-$id"; ?>">
                        <?= $cat; ?>
                    </label>
                    <a href="<?= $rename_link ?>" class=" btn btn-primary col-lg-1 col-md-2">
                        Rename
                    </a>
                    <form action="<?= route("api/archive") ?>" method="post" class=" d-inline-block col-lg-1 col-md-2">
                        <input type="hidden" name="selected" value="category">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <button class=" btn btn btn-warning">
                            Archive
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>