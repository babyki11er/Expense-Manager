<?php require_once "./header.php" ?>

<!-- ADD NEW CATEGORY FORM -->
<div class=" container">
    <form action="edit-api.php" method="post" class=" p-4">
        <div class="mb-2">
            <label for="" class=" form-label">
                New Category
            </label>
        </div>
        <div class=" input-group">
            <input name="value" type="text" id="" placeholder="Enter new category" class=" form-control" autofocus />
            <button class="btn btn-primary col-4">Add</button>
        </div>
        <input type="hidden" name="selected" value="category">
    </form>
</div>

<?php require_once "./footer.php" ?>