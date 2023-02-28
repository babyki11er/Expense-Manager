<?php

use function PHPSTORM_META\sql_injection_subst;

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
function db_Insert(mysqli $conn, string $selected, array $key_value): int
{
    // do validation for SQL injection, XSS, security stuffs
    $sql = _makeInsertStatement($selected, $key_value);
    if (in_array($selected, [CATEGORY, ITEM, RECORD, INCOME])) {
        if (_execQuery($conn, $sql)) {
            return mysqli_insert_id($conn);
        } else {
            return DB_ERROR;
        }
    }
    return VALIDATE_ERROR;
}

function db_SelectOne(mysqli $conn, string $selected, array $where, string $selector='*'): array
{
    $sql = _makeSelectStatement($selected, $where, $selector);
    return _fetchOne($conn, $sql);
}

function db_SelectAll(mysqli $conn, string $selected, array $where, string $selector='*', string $ordered_by = "id") : array 
{
    $sql = _makeSelectStatement($selected, $where, $selector, $ordered_by);
    return _fetchAll($conn, $sql);
}

function db_Update(mysqli $conn, string $selected, int $id, array $values, array $where=null): int
{
    // do validation for SQL injection, XSS, security stuffs
    // NOT CHECKING IF THE id EXISTS OR NOT
    $sql = _makeUpdateStatement($selected, $values, $id, $where);
    if (in_array($selected, [CATEGORY, ITEM, RECORD, INCOME])) {
        if (_execQuery($conn, $sql)) {
            return $id;
        } else {
            return DB_ERROR;
        }
    }
    return VALIDATE_ERROR;
}

function db_Delete(mysqli $conn, string $selected, int $id, array $where=null): int
{
    $sql = _makeDeleteStatement($selected, $id, $where);
    if (in_array($selected, [CATEGORY, ITEM, RECORD, INCOME])) {
        if (_execQuery($conn, $sql)) {
            return $id;
        } else {
            return DB_ERROR;
        }
    }
    return VALIDATE_ERROR;
}

/* private functions */

function _execQuery(mysqli $conn, string $sql, bool $close = true)
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

function _fetchOne(mysqli $conn, string $sql) 
{
    $result = _execQuery($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function _fetchAll(mysqli $conn, string $sql)
{
    $result = _execQuery($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function _makeInsertStatement(string $selected, $key_value) : string
{
    $columns = implode(', ',array_keys($key_value));
    $values = "";
    foreach($key_value as $value) {
        $values .= _sqlValue($value) . ", ";
    }
    $values = rtrim($values, ", ");
    $sql = "INSERT INTO $selected ($columns) VALUES ($values);";
    // echo $sql;
    return $sql;
}

function _makeSelectStatement(string $selected, array $where, string $selector="*", string $order_by="id") : string
{
    $sql = "SELECT $selector FROM $selected";
    if (!empty($where)) {
        $sql .= " WHERE ";
        foreach($where as $key => $value) {
            $value = _sqlValue($value);
            $sql .= " $key=$value,";
        }
        $sql = rtrim($sql, ",");
    }

    $sql .= " ORDER BY $order_by;";
    // echo $sql;
    return $sql;
}

function _makeUpdateStatement(string $selected, array $key_value, int $id, array $where=null) : string
{
    $sql = "UPDATE $selected SET";
    foreach($key_value as $key => $value) {
        $value = _sqlValue($value);
        $sql .= " $key=$value,";
    }
    $sql = rtrim($sql, ",");
    $sql .= " WHERE id=$id";
    if (!is_null($where)) {
        foreach($where as $column => $value) {
            $value = _sqlValue($value);
            $sql .= " AND $column=$value";
        }
    }
    // echo $sql;
    return $sql;
}

function _makeDeleteStatement(string $selected, int $id, array $where=null) : string
{
    $sql = "DELETE FROM $selected WHERE id=$id";
    if (!is_null($where)) {
        foreach($where as $column => $value) {
            $value = _sqlValue($value);
            $sql .= " AND $column=$value";
        }
    }
    echo $sql;
    return $sql;
}

function _sqlValue($value) : string
{
    if (gettype($value) === 'string') {
        $value = "'$value'";
    }
    return $value;
}