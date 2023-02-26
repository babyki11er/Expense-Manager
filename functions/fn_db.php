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
function db_InsertNew(mysqli $conn, string $selected, array $value): int
{
    // do validation for SQL injection, XSS, security stuffs
    switch($selected) {
        case CATEGORY:
            $sql = "INSERT INTO " . CATEGORY . " (name) VALUES ('". $value['name'] . "'); ";
            break;
        case ITEM:
            $name = $value['name'];
            $price = $value['price'];
            $cat_id = $value['cat_id'];
            $sql = "INSERT INTO " . ITEM . " (name, price, cat_id) VALUES ('$name', $price, $cat_id);";
            break;
        case RECORD:
            $item_id = $value['item_id'];
            $qty = $value['qty'];
            $note = $value['note'];
            $date = $value['date'];
            $sql = "INSERT INTO record (item_id, qty, note, date) VALUES ($item_id, $qty, '$note', '$date') ";
            break;
        case INCOME:
            $amount = $value['amount'];
            $label = $value['label'];
            $date = $value['date'];
            $note = $value['note'];
            $sql = "INSERT INTO income (amount, label, date, note) VALUES ($amount, '$label', '$date', '$note');";
            break;
        default:
            return VALIDATE_ERROR;
    }
    if (_execQuery($conn, $sql, false)) {
        return mysqli_insert_id($conn);
    } else {
        return DB_ERROR;
    }
}

function db_Update(mysqli $conn, string $selected, int $id, array $value) : bool
{
    // do validation for SQL injection, XSS, security stuffs
    // NOT CHECKING IF THE id EXISTS OR NOT
    switch($selected) {
        case CATEGORY:
            $sql = "INSERT INTO " . CATEGORY . " (name) VALUES ('". $value['name'] . "'); ";
            break;
        case ITEM:
            $name = $value['name'];
            $price = $value['price'];
            $cat_id = $value['cat_id'];
            $sql = "UPDATE item SET name='$name', price=$price, cat_id=$cat_id WHERE id=$id;";
            break;
            case RECORD:
                $item_id = $value['item_id'];
                $qty = $value['qty'];
                $note = $value['note'];
                $date = $value['date'];
                $sql = "UPDATE record SET item_id=$item_id, qty=$qty, note='$note', date='$date' WHERE id=$id;";
                break;
            case INCOME:
                $amount = $value['amount'];
                $label = $value['label'];
                $date = $value['date'];
                $note = $value['note'];
                $sql = "UPDATE income SET amount=$amount, label='$label', date='$date', note='$note' WHERE id=$id;";
                break;
            default:
                return VALIDATE_ERROR;
        }
        if (_execQuery($conn, $sql)) {
            return $id;
    } else {
        return DB_ERROR;
    }
}

function db_SelectItemNames(mysqli $conn) : array
{
    $sql = "SELECT name FROM item WHERE archive='active'";
    $result = _execQuery($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_SelectItemsByCategory(mysqli $conn, int $cat_id) : array
{
    $sql = "SELECT * FROM item WHERE archive='active' AND cat_id=$cat_id";
    $result = _execQuery($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_SelectActive(mysqli $conn, string $selected, string $ordered_by = "id"): array
{
    switch($selected) {
        case CATEGORY:
            $sql = "SELECT * FROM " . CATEGORY . " WHERE archive='active' ORDER BY $ordered_by";
            break;
        case ITEM:
            $sql = "SELECT * FROM " . ITEM . " WHERE archive='active' ORDER BY $ordered_by";
            break;
        case RECORD:
            $sql = "SELECT * FROM " . RECORD . " ORDER BY $ordered_by";
            break;
        case INCOME:
            $sql = "SELECT * FROM " . INCOME . " ORDER BY $ordered_by";
            break;
    }
    $result = _execQuery($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_SelectOne(mysqli $conn, string $selected, int $id) : array
{
    switch($selected) {
        case CATEGORY:
            $sql = "SELECT * FROM " . CATEGORY . " WHERE id=$id;";
            break;
        case ITEM:
            $sql = "SELECT * FROM " . ITEM . " WHERE id=$id;";
            break;
        case RECORD:
            $sql = "SELECT * FROM " . RECORD . " WHERE id=$id;";
            break;
        case INCOME:
            $sql = "SELECT * FROM " . INCOME . " WHERE id=$id;";
            break;
        default:
            return [];
    }
    $result = _execQuery($conn, $sql);
    $fetched = mysqli_fetch_assoc($result);
    if (is_null($fetched)) {
        slayer();
        dd($result);
        dd($sql);
        return [];
    }
    return $fetched;
}

function db_Archive(mysqli $conn, string $selected, int $id) : bool
{
    switch($selected) {
        case CATEGORY:
            $sql = "UPDATE " . CATEGORY . " SET archive='archived' WHERE id=$id";
            break;
        case ITEM:
            $sql = "UPDATE " . ITEM . " SET archive='archived' WHERE id=$id";
            break;
        // case RECORD:
        //     $sql = "UPDATE SET " . RECORD . " archive='archived' WHERE id=$id";
        //     break;
        // case INCOME:
        //     $sql = "UPDATE SET " . INCOME . " archive='archived' WHERE id=$id";
        //     break;
        default:
            return DB_ERROR;
    }
    if (_execQuery($conn, $sql)) {
        return $id;
    } else {
        return DB_ERROR;
    }
}


function db_CheckExistence(mysqli $conn, string $selected, int $id) : bool
{
    switch($selected) {
        case CATEGORY:
            $sql = "SELECT id FROM " . CATEGORY . " WHERE id=$id;";
            break;
        case ITEM:
            $sql = "SELECT id FROM " . ITEM . " WHERE id=$id;";
            break;
        case RECORD:
            $sql = "SELECT id FROM " . RECORD . " WHERE id=$id";
            break;
        case INCOME:
            $sql = "SELECT id FROM " . INCOME . " WHERE id=$id";
            break;
    }
    $result = _execQuery($conn, $sql);
    if (is_null(mysqli_fetch_assoc($result))) {
        return false;
    } else {
        return true;
    }
}

function db_Delete(mysqli $conn, string $selected, int $id) : int
{
    switch($selected) {
        case CATEGORY:
            $sql = "DELETE FROM " . CATEGORY . " WHERE id=$id;";
            break;
        case ITEM:
            $sql = "DELETE FROM " . ITEM . " WHERE id=$id;";
            break;
        case RECORD:
            $sql = "DELETE FROM " . RECORD . " WHERE id=$id;";
            break;
        case INCOME:
            $sql = "DELETE FROM " . INCOME . " WHERE id=$id;";
            break;
        default:
            return VALIDATE_ERROR;
    }
    if (_execQuery($conn, $sql)) {
        return $id;
    } else {
        return DB_ERROR;
    }
}

/* private functions */

function _execQuery(mysqli $conn, string $sql, bool $close=true)
{
    _html_log($sql);
    $query_result = mysqli_query($conn, $sql);
    if ($query_result === false) {
        noti("MySql Error: $sql");
        LogConsole("MySql Error: $sql");
    }
    // if ($close) {
    //     mysqli_close($conn);
    // }
    return $query_result;
}