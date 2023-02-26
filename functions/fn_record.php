<?php
/*
    ALL THESE FUNCTIONS DEAL WITH RECORDS, VALIDATE ACCORDING TO THE RECORD RULES AND nothing else!
*/
/* Record:

        item_id     int
        item_name   string(computed)
        qty         int
        cost        int(computed)
        date        str
        note        str


    deleteRecord($id)   => compeletely remove from the data, no DELETED string is left at all
*/

function _makeRecord(int $item_id, int $qty, string $date, string $note) : array
{
    return [
        'item_id' => $item_id,
        'qty' => $qty,
        'date' => $date,
        'note' => $note
    ];
}

function getRecordsPublic(mysqli $conn): array
{
    $raw_records = db_SelectActive($conn, RECORD, "date");
    return array_map(function ($raw) use ($conn) {
        $record_public = $raw;
        $related_item_id = $raw['item_id'];
        $related_item = getItem($related_item_id, $conn);
        $record_public['item_name'] = $related_item['name'];
        $record_public['cost'] = $related_item['price'] * $raw['qty'];
        $record_public['cat_str'] = $related_item['cat_str'];
        return $record_public;
    }, $raw_records);
    // db_SelectRecords(), then call other db functions to fetch for the view
}

// add a new record, returns the id
function addNewRecord(int $item_id, int $qty, string $date, string $note, mysqli $conn): int
{
    // FIX
    //  date is not included yet
    // do some validation based on record rules
    // $new_record = _makeRecord($item_id, $qty, $date, $note);
    $record_to_add = _makeRecord($item_id, $qty, $date, $note);
    if (db_InsertNew($conn, RECORD, $record_to_add)) {
        return mysqli_insert_id($conn);
    } else {
        return DB_ERROR;
    }
}

function updateRecord(int $id, int $item_id, int $qty, string $date, string $note, mysqli $conn): int
{
    if (!_checkRecord($id, $conn)) {
        return VALIDATE_ERROR;
    }
    $record_to_add = _makeRecord($item_id, $qty, $date, $note);
    if (db_Update($conn, RECORD, $id, $record_to_add)) {
        return $id;
    } else {
        return DB_ERROR;
    }
}

function _checkRecord(int $id, mysqli $conn) : bool
{
    return db_CheckExistence($conn, RECORD, $id);
}

function deleteRecord(int $id, mysqli $conn): int
{
    if (db_Delete($conn, RECORD, $id)) {
        return $id;
    } else {
        return DB_ERROR;
    }
}

// function _validateRecord(int $id): bool
// {
//     // validation not to fuck up the security
// }
function getTotalOutcome(mysqli $conn): int
{
    $raw_records = db_SelectActive($conn, RECORD);
    return array_reduce($raw_records, function ($carry, $raw_record) use ($conn) {
        $related_item = getItem($raw_record['item_id'], $conn);
        $cost = $related_item['price'] * $raw_record['qty'];
        return $carry + $cost;
    }, 0);
}