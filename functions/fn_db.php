<?php


function connectMysql()
{
    $_hostname = 'localhost';
    $_username = 'sid';
    $_password = 'six';
    $_dbname = 'expense_tracker';
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

function db_UpdateCategory(mysqli $conn, int $id, string $new_name) : bool
{
    $sql = "UPDATE category SET name='$new_name' WHERE id=$id;";
    return mysqli_query($conn, $sql);
}

function db_SelectCategories($conn, $ordered_by = "id"): array
{
    $sql = "SELECT * FROM " . CATEGORY . " WHERE archive='active' order by $ordered_by;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_ArchiveACategory($conn, int $id): bool
{
    $sql = "update category set archive='archived' where id=$id;";
    return mysqli_query($conn, $sql);
}

function db_SelectACategory($conn, int $id): string
{
    $sql = "SELECT * FROM " . CATEGORY . " WHERE id = $id;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)['name'];
}

function db_DeleteCategory(mysqli $conn, int $id) : bool
{
    $sql = "DELETE FROM category WHERE id=$id;";
    return mysqli_query($conn, $sql);
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

function db_UpdateItem(mysqli $conn, int $id, string $name, int $price, int $cat_id) : bool
{
    $sql = "UPDATE item SET name='$name', price=$price, cat_id=$cat_id WHERE id=$id;";
    return mysqli_query($conn, $sql);
}

function db_SelectExistenceItem(mysqli $conn, int $id) : bool
{
    $sql = "SELECT id FROM item WHERE id=$id AND archive='active';";
    $result = mysqli_query($conn, $sql);
    $id = mysqli_fetch_assoc($result);
    if (is_null($id)) {
        return false;
    }
    return true;
}

function db_SelectItems($conn): array
{
    $sql = "SELECT * FROM " . ITEM . " WHERE archive='active';";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_SelectItemNames(mysqli $conn) : array
{
    $sql = "SELECT id,name FROM item WHERE archive='active';";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_SelectAnItem($conn, int $id): array
{
    $sql = "SELECT * FROM " . ITEM . " WHERE id = $id;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function db_SelectItemsByCategory(mysqli $conn, int $cat_id) : array
{
    $sql = "SELECT * FROM item WHERE cat_id=$cat_id;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_ArchiveAnItem($conn, int $id): bool
{
    $sql = "update item set archive='archived' where id=$id;";
    return mysqli_query($conn, $sql);
}

function db_DeleteItem(mysqli $conn, int $id) : bool
{
    $sql = "DELETE FROM item WHERE id=$id;";
    return mysqli_query($conn, $sql);
}
/*
RECORD
*/
function db_InsertNewRecord($conn, int $item_id, int $qty, string $note, string $date): int
{
    // do some validations
    $sql = "INSERT INTO record (item_id, qty, note, date) VALUES ($item_id, $qty, '$note', '$date') ";
    return mysqli_query($conn, $sql);
}

function db_UpdateRecord(mysqli $conn, int $id, int $item_id, int $qty, string $note, string $date) : int
{
    // do some validations
    $sql = "UPDATE record SET item_id=$item_id, qty=$qty, note='$note', date='$date' WHERE id=$id;";
    return mysqli_query($conn, $sql);
}

function db_SelectRecords(mysqli $conn, string $order = "date"): array
{
    // one query for selecting all active records, nothing else to mess shit up
    $sql = "SELECT * FROM record ORDER BY $order;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_DeleteRecord($conn, int $record_id): bool
{
    $sql = "DELETE FROM record WHERE id=$record_id;";
    return mysqli_query($conn, $sql);
}
/*
    Income
*/

function db_InsertNewIncome(mysqli $conn, int $amount, string $label, string $date, string $note): bool
{
    $sql = "INSERT INTO income (amount, label, date, note) VALUES ($amount, '$label', '$date', '$note');";
    // echo $sql;
    // return false;
    return mysqli_query($conn, $sql);
}

function db_UpdateIncome(mysqli $conn, int $id, int $amount, string $label, string $date, string $note) : bool
{
    $sql = "UPDATE income SET amount=$amount, label='$label', date='$date', note='$note';";
    return mysqli_query($conn, $sql);
}

function db_SelectIncomes(mysqli $conn): array
{
    $sql = "SELECT * FROM income;";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_DeleteIncome(mysqli $conn, int $id): bool
{
    $sql = "DELETE FROM income WHERE id=$id;";
    return mysqli_query($conn, $sql);
}
