<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(1);


/*
    CATEGORY:
        id  =>  int
        name=>  string
*/
function listCategories(mysqli $conn): array
{
    $order = getOrder(CATEGORY, 'name');
    $raw_categories = db_SelectAll($conn, CATEGORY, ['status' => 'active'], '*', $order);
    return is_null($raw_categories) ? [] : $raw_categories;
}

function getCategoryName(int $id, $conn): ?string
{
    $raw_category =  db_SelectOne($conn, CATEGORY, ['id' => $id], 'name');
    return $raw_category['name'];
}

function addNewCategory(string $category, mysqli $conn): int
{
    // ? some validations not to end up with fucked objects ?
    return db_Insert($conn, CATEGORY, ['name' => $category]);
}

function updateCategory(int $id, string $category, mysqli $conn) : bool
{
    if (_checkCatId($id, $conn)) {
        return db_Update($conn, CATEGORY, ['name' => $category], ['id' => $id]);
    }
    return false;
}

function _checkCatId(int $id, mysqli $conn) : bool
{
    return !is_null(db_SelectOne($conn, CATEGORY, ['id' => $id], 'id'));
}

function existCategory(string $category_name, mysqli $conn) : int
{
    $category = db_SelectOne($conn, CATEGORY, ['name' => $category_name], 'id');
    if (is_null($category)) {
        return NOT_EXIST;
    } else {
        return $category['id'];
    }
}

function archiveCategory(int $id, mysqli $conn): bool
{
    $e_code = db_Update($conn, CATEGORY, ['status' => 'archived'], ['id' => $id]);
    if ($e_code) {
        db_Update($conn, CATEGORY, ['status' => 'archived'], ['cat_id' => $id]);
    }
    return $e_code;
}

function unarchiveCategory(int $id, mysqli $conn) : bool
{
    $e_code = db_Update($conn, CATEGORY, ['status' => 'active'], ['id' => $id]);
    if ($e_code) {
        db_Update($conn, CATEGORY, ['status' => 'active'], ['cat_id' => $id]);
    }
    return $e_code;
}