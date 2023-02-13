<?php
/*
    Categories:
        no attribute, it is just a dumb string
    Properties:
        name    string
        price   int
        cat_id  int (foregin key)
    Public interface:
        listCategories();  => array with id as index
            filtered archive items for public view
        getCategory($id);   => category name string
        addNewCategory($id);    => id of the added category
        archiveCategory($id);   => int
*/


function listCategories(mysqli $conn): array
// returns categories available to use in coming items
{
    $raw_categories = db_SelectCategories($conn, 'name');
    return array_map(function ($val) {
        return [
            'id' => $val['id'],
            'name' => $val['name']
        ];
    }, $raw_categories);
}

function getCategoryName(int $id, $conn): string
{
    return db_SelectACategory($conn, $id);
}

function addNewCategory(string $category, mysqli $conn): int
{
    // ? some validations not to end up with fucked objects ?
    $to_add = ucfirst($category);
    if (db_InsertNewCategory($conn, $to_add)) {
        return mysqli_insert_id($conn);
    } else {
        return DB_ERROR;
    }
}
