<?php
/*
    Variables:
        $form_action    string
        $update         bool
            $id
            $category       string
*/

if (!$update) {
    $category = '';
}
?>
<h1>
    <?= $update ? "Edit Category" : "Create New Categories" ?>
</h1>

<div class=" d-flex justify-content-between m-4 mb-2">
    <a href="<?= route("categories") ?>" class=" btn btn-outline-dark">All Categories</a>
</div>

<!-- ADD NEW CATEGORY FORM -->
<div class=" w-50">
    <form action="<?= $form_action; ?>" method="post" class=" p-4">
        <div class="mb-2">
            <label for="" class=" form-label">
                <?php if ($update) : ?>
                    Update Category
                <?php else : ?>
                    New Category
                <?php endif; ?>
            </label>
        </div>
        <div class=" input-group" id="dd">
            <input name="value" type="text" value="<?= $category ?>" placeholder="Enter new category" class=" form-control" autofocus />
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