<?php


/*
    CATEGORY:
        id  =>  int
        name=>  string
*/
function listCategories(mysqli $conn): array
// returns categories available to use in coming items
{
    $raw_categories = db_SelectAll($conn, CATEGORY, ['status' => 'active']);
    return $raw_categories;
}

function getCategoryName(int $id, $conn): string
{
    $raw_category =  db_SelectOne($conn, CATEGORY, ['id' => $id], 'name');
    return $raw_category['name'];
}

function addNewCategory(string $category, mysqli $conn): int
{
    // ? some validations not to end up with fucked objects ?
    return db_Insert($conn, CATEGORY, ['name' => $category]);
}

function updateCategory(int $id, string $category, mysqli $conn) : int
{
    if (!_checkCatId($id, $conn)) {
        return VALIDATE_ERROR;
    }
    return db_Update($conn, CATEGORY, $id, ['name' => $category]);
}

function _checkCatId(int $id, mysqli $conn) : bool
{
    return !is_null(db_SelectOne($conn, CATEGORY, ['id' => $id], 'id'));
}

function categoryExists(string $category_name, mysqli $conn) : int
{
    $category = db_SelectOne($conn, CATEGORY, ['name' => $category_name]);
    if (is_null($category)) {
        return VALIDATE_ERROR;
    } else {
        return $category['id'];
    }
}


function archiveCategory(int $id, mysqli $conn): int
{
    $e_code = db_Update($conn, CATEGORY, $id, ['status' => 'archived']);
    if ($e_code === $id) {
        // need refactoring
        $sql = "UPDATE item SET status='archived' WHERE cat_id=$id";
        _execQuery($conn, $sql);
    }
    return $e_code;
}

function unarchiveCategory(int $id, mysqli $conn) :int 
{
    $e_code = db_Update($conn, CATEGORY, $id, ['status' => 'active']);
    if ($e_code === $id) {
        // need refactoring
        $sql = "UPDATE item SET status='active' WHERE cat_id=$id";
        _execQuery($conn, $sql);
    }
    return $e_code;
}