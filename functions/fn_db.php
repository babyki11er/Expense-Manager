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

function insertCategory($conn, string $name): bool
{
    // do some validations
    $sql = "INSERT INTO category (name) VALUES ($name)";
    return mysqli_query($conn, $name);
}

function insertItem($conn, string $name, int $price, int $cat_id): bool
{
    // do some validations
    $sql = "INSERT INTO item (name, price, cat_id) VALUES ($name, $price, $cat_id)";
    return mysqli_query($conn, $name, $price, $cat_id);
}

// function insertRecord($conn, int $item_id, int $qty, string $note): bool
// {
//     $sql = "INSERT INTO record (item_id, qty, ";
// }
