<?php


/*
Incomes:

    amount  int
    label   str
    date    str
    note    str
*/

function addIncome(int $amount, string $label, string $date, string $note, mysqli $conn): int
{
    // validation according to income object
    if (empty($date) || empty($amount) || empty($label)) {
        return VALIDATE_ERROR;
    }
    if ($amount <= 0) {
        return VALIDATE_ERROR;
    }
    if (db_InsertNewIncome($conn, $amount, $label, $date, $note)) {
        return mysqli_insert_id($conn);
    } else {
        return DB_ERROR;
    }
}

function getTotalIncome(mysqli $conn): int
{
    $raw_incomes = db_SelectIncomes($conn);
    $total = array_reduce($raw_incomes, function ($carry, $raw) {
        return $carry + $raw['amount'];
    }, 0);
    return $total;
}
