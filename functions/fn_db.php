<?php


function connectMysql()
{
    $_hostname = 'localhost';
    $_username = 'sid';
    $_password = 'six';
    $_dbname = "expense_tracker";
    $conn = mysqli_connect($_hostname, $_username, $_password, $_dbname);
    return $conn;
}

/*
    CATEGORY:
*/
function db_InsertNewCategory($conn, string $name): bool
{
    // do validation for SQL injection, XSS, security stuffs
    $sql = "INSERT INTO " . CATEGORY . " (name) VALUES ('$name'); ";
    return mysqli_query($conn, $sql);
}

function db_SelectCategories($conn, $ordered_by = "id"): array
{
    $sql = "SELECT * FROM " . CATEGORY . " WHERE archive='active' order by $ordered_by;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_SelectACategory($conn, int $id): string
{
    $sql = "SELECT * FROM " . CATEGORY . " WHERE id = $id;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)['name'];
}
/*
ITEM
*/
function db_InsertNewItem($conn, string $name, int $price, int $cat_id): bool
{
    // do some validations
    $sql = "INSERT INTO " . ITEM . " (name, price, cat_id) VALUES ('$name', $price, $cat_id);";
    return mysqli_query($conn, $sql);
}

function db_SelectItems($conn): array
{
    $sql = "SELECT * FROM " . ITEM . " WHERE archive='active';";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_SelectAnItem($conn, int $id): array
{
    $sql = "SELECT * FROM " . ITEM . " WHERE id = $id;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}
/*
RECORD
*/
function db_InsertNewRecord($conn, int $item_id, int $qty, string $note): bool
{
    // do some validations
    $sql = "INSERT INTO record (item_id, qty, note) VALUES ($item_id, $qty, $note) ";
    return mysqli_query($conn, $sql);
}
