<?php

function list_(mysqli $conn): void
{
    if (isset($_GET['order'])) {
        setOrder(CATEGORY, $_GET['order']);
    }
    $categories = listCategories($conn);
    $data = [
        'categories' => $categories
    ];
    view("category/list", $data);
}


function add(mysqli $conn): void
{
    $form_action_link = route("api/add");
    $data = [
        'form_action' => $form_action_link,
        'update' => false
    ];
    view("category/form", $data);

    // $categories = listCategories($conn);
    // $data = [
    //     'categories' => $categories
    // ];
    // view("category/list", $data);
    // yellow, i don't want separate pages for category, since i make sense to be able to see existing categories
}

function edit(mysqli $conn): void
{
    $id = $_GET['id'];
    $categroy_to_update = getCategoryName($id, $conn);
    if (is_null($categroy_to_update)) {
        echo "<h4>Category you are trying to edit is either deleted or does not exist.</h4>";
        view("404");
    } else {
        $form_action_link = route('api/update');
        $data = [
            'form_action' => $form_action_link,
            'category' => $categroy_to_update,
            'update' => True,
            'id' => $id
        ];
        view("category/form", $data);
    }
}
