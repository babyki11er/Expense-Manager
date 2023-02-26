<?php


/*
    CATEGORY:
        id  =>  int
        name=>  string
*/
function listCategories(mysqli $conn): array
// returns categories available to use in coming items
{
    $raw_categories = db_SelectActive($conn, CATEGORY);
    return $raw_categories;
}

function getCategoryName(int $id, $conn): string
{
    $raw_category =  db_SelectOne($conn, CATEGORY, $id);
    return $raw_category['name'];
}

function addNewCategory(string $category, mysqli $conn): int
{
    // ? some validations not to end up with fucked objects ?
    $to_add = ucfirst($category);
    return db_InsertNew($conn, CATEGORY, ['name' => $to_add]);
}

function updateCategory(int $id, string $category, mysqli $conn) : int
{
    if (!_checkCategory($id, $conn)) {
        return VALIDATE_ERROR;
    }
    return db_Update($conn, CATEGORY, $id, ['name' => $category]);
}

function _checkCategory(int $id, mysqli $conn) : bool
{
    return db_CheckExistence($conn, CATEGORY, $id);
}


function archiveCategory(int $id, mysqli $conn): int
{
    return db_Archive($conn, CATEGORY, $id);
}
