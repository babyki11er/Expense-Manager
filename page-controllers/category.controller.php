<?php

// controller
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