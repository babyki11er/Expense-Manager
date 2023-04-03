<?php

function connectMysql()
{
    // config db here
    $_hostname = 'localhost';
    $_username = 'sid';
    $_password = 'six';
    $_dbname = 'expense_tracker';
    $conn = mysqli_connect($_hostname, $_username, $_password, $_dbname);
    return $conn;
}

/*
misc
pure yellow, i don't have one clear idea with SQL statements, i will learn that for sure, then later, i can improve this code
*/
function getMonths(mysqli $conn) : array
{
    $sql = "select distinct month(date) as Month from record;";
    $r = _execQuery($conn, $sql);
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

/*
    db functions should not be concerned with the structure of the data, rather with security
    we will be assuming every resource we add or deleted are valid
*/
function db_Insert(mysqli $conn, string $selected, array $key_value): int
{
    // do validation for SQL injection, XSS, security stuffs
    $sql = _makeInsertStatement($selected, $key_value);
    if (_execQuery($conn, $sql)) {
        return mysqli_insert_id($conn);
    } else {
        return DB_ERROR;
    }
}


function db_Update(mysqli $conn, string $selected, array $values, array $where): bool
{
    // do validation for SQL injection, XSS, security stuffs
    // NOT CHECKING IF THE id EXISTS OR NOT
    $sql = _makeUpdateStatement($selected, $values, $where);
    return _execQuery($conn, $sql, true);
}

function db_Delete(mysqli $conn, string $selected, int $id, array $where = null): bool
{
    $sql = _makeDeleteStatement($selected, $id, $where);
    return _execQuery($conn, $sql);
}

/* private functions */

function _execQuery(mysqli $conn, string $sql, bool $close = true): bool | mysqli_result
{
    // _html_log($sql);
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

function db_SelectOne(mysqli $conn, string $selected, array $where, string $selector = '*'): ?array
{
    $sql = _makeSelectStatement($selected, $where, $selector);
    return _fetchOne($conn, $sql);
}

function db_SelectAll(mysqli $conn, string $selected, array $where, string $selector = '*', string $ordered_by = "id"): ?array
{
    $sql = _makeSelectStatement($selected, $where, $selector, $ordered_by);
    $fetched = _fetchAll($conn, $sql);
    return $fetched;
}
function _fetchOne(mysqli $conn, string $sql): ?array
{
    $result = _execQuery($conn, $sql);
    $fetched = mysqli_fetch_assoc($result);
    return $fetched;
}

function _fetchAll(mysqli $conn, string $sql): ?array
{
    $result = _execQuery($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function _makeInsertStatement(string $selected, $key_value): string
{
    $columns = implode(', ', array_keys($key_value));
    $values = "";
    foreach ($key_value as $value) {
        $values .= _sqlValue($value) . ", ";
    }
    $values = rtrim($values, ", ");
    $sql = "INSERT INTO $selected ($columns) VALUES ($values);";
    // echo $sql;
    return $sql;
}

function _makeSelectStatement(string $selected, array $where, string $selector = "*", string $order_by = "id"): string
{
    $sql = "SELECT $selector FROM $selected";
    if (!empty($where)) {
        $sql .= " WHERE ";
        foreach ($where as $key => $value) {
            $value = _sqlValue($value);
            $sql .= " $key=$value AND";
        }
        $sql = rtrim($sql, "AND");
    }

    $sql .= " ORDER BY $order_by";
    // echo $sql;
    return $sql;
}

function _makeUpdateStatement(string $selected, array $key_value, array $where): string
{
    $sql = "UPDATE $selected SET";
    foreach ($key_value as $key => $value) {
        $value = _sqlValue($value);
        $sql .= " $key=$value,";
    }
    $sql = rtrim($sql, ",");
    $sql .= " WHERE";
    foreach ($where as $column => $value) {
        $value = _sqlValue($value);
        $sql .= " $column=$value AND";
    }
    $sql = rtrim($sql, ' AND');
    return $sql;
}

function _makeDeleteStatement(string $selected, int $id, array $where = null): string
{
    $sql = "DELETE FROM $selected WHERE id=$id";
    if (!is_null($where)) {
        foreach ($where as $column => $value) {
            $value = _sqlValue($value);
            $sql .= " AND $column=$value";
        }
    }
    echo $sql;
    return $sql;
}

function _sqlValue($value): string
{
    if (gettype($value) === 'string') {
        $value = "'$value'";
    }
    return $value;
}
