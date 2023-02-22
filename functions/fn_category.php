<?php


/*
    CATEGORY:
        id  =>  int
        name=>  string
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

function updateCategory(int $id, string $category, mysqli $conn) : int
{
    if (!_checkCategory($id, $conn)) {
        return VALIDATE_ERROR;
    }
    if (db_UpdateCategory($conn, $id, $category)) {
        return $id;
    } else {
        return DB_ERROR;
    }
}

function _checkCategory(int $id, mysqli $conn) : bool
{
    return db_SelectExistenceCategory($conn, $id);
}


function archiveCategory(int $id, mysqli $conn): int
{
    if (db_ArchiveACategory($conn, $id)) {
        return $id;
    } else {
        return DB_ERROR;
    }
}
