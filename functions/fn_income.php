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

    $income_to_add = _makeIncome($amount, $label, $date, $note);
    return db_Insert($conn, INCOME, []);
}

function _makeIncome(int $amount, string $label, string $date, string $note) : array
{
    return [
        'amount' => $amount,
        'label' => $label,
        'date' => $date,
        'note' => $note
    ];
}

function updateIncome(int $id, int $amount, string $label, string $date, string $note, mysqli $conn) : int
{
    $income_to_update = _makeIncome($amount, $label, $date, $note);
    if (_checkIncome($id, $conn)) {
        if (db_Update($conn, INCOME, $id, $income_to_update)) {
            return $id;
        } else {
            return DB_ERROR;
        }
    } else {
        return VALIDATE_ERROR;
    }
}

function deleteIncome(int $id, mysqli $conn) : int
{
    if (_checkIncome($id, $conn)) {
        if (db_Delete($conn, INCOME , $id)) {
            return $id;
        } else {
            return DB_ERROR;
        }
    } else {
        return VALIDATE_ERROR;
    }
}

function listIncomes(mysqli $conn) : array
{
    $raw_incomes = db_SelectAll($conn, INCOME, [], '*', 'date');
    return $raw_incomes;
}

function getIncome(int $id, mysqli $conn) : array
{
    return db_SelectOne($conn, INCOME, ['id' => $id]);
}

function getTotalIncome(mysqli $conn): int
{
    $raw_incomes = db_SelectAll($conn, INCOME, [], '*', 'date');
    $total = array_reduce($raw_incomes, function ($carry, $raw) {
        return $carry + $raw['amount'];
    }, 0);
    return $total;
}

function _checkIncome(int $id, mysqli $conn) : bool
{
    return !is_null(db_SelectOne($conn, INCOME, ['id' => $id], 'id'));
}