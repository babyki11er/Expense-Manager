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

function getRecordsPublic(mysqli $conn, string $order): array
{
    $raw_records = db_SelectAll($conn, RECORD, [], '*', $order);
    return is_null($raw_records) ? [] :
    array_map(function ($raw) use ($conn) {
        $record_public = $raw;
        $related_item_id = $raw['item_id'];
        $related_item = getItemById($related_item_id, $conn);
        $record_public['item_name'] = $related_item['name'];
        $record_public['cost'] = $related_item['price'] * $raw['qty'];
        $record_public['cat_str'] = $related_item['cat_str'];
        return $record_public;
    }, $raw_records);
    // db_SelectRecords(), then call other db functions to fetch for the view

}

function getRecord(mysqli $conn, int $id) : array 
{
    $raw_record = db_SelectOne($conn, RECORD, ['id' => $id]);
    if (is_null($raw_record)) {
        return [];
    }
    $related_item = getItemById($raw_record['item_id'], $conn);
    $raw_record['item_name'] = $related_item['name'];
    $raw_record['item_price'] = $related_item['price'];
    $raw_record['cost'] = $related_item['price'] * $raw_record['qty'];
    $raw_record['cat_str'] = $related_item['cat_str'];
    $raw_record['cat_id'] = $related_item['cat_id'];
    return $raw_record;
}

// add a new record, returns the id
function addNewRecord(int $item_id, int $qty, string $date, string $note, mysqli $conn): int
{
    // FIX
    //  date is not included yet
    // do some validation based on record rules
    // $new_record = _makeRecord($item_id, $qty, $date, $note);
    $record_to_add = _makeRecord($item_id, $qty, $date, $note);
    return db_Insert($conn, RECORD, $record_to_add);
}

function updateRecord(int $id, int $item_id, int $qty, string $date, string $note, mysqli $conn): int
{
    if (!_checkRecord($id, $conn)) {
        return VALIDATE_ERROR;
    }
    $record_to_add = _makeRecord($item_id, $qty, $date, $note);
    return db_Update($conn, RECORD, $id, $record_to_add);
}

function _checkRecord(int $id, mysqli $conn) : bool
{
    return !is_null(db_SelectOne($conn, RECORD, ['id' => $id], 'id'));
}

function deleteRecord(int $id, mysqli $conn): int
{
    return db_Delete($conn, RECORD, $id);
}

// function _validateRecord(int $id): bool
// {
//     // validation not to fuck up the security
// }
function getTotalOutcome(mysqli $conn): int
{
    $raw_records = db_SelectAll($conn, RECORD, []);
    // dd($raw_records, true);
    return is_null($raw_records) ? 0 :
    array_reduce($raw_records, function ($carry, $raw_record) use ($conn) {
        $related_item = getItemById($raw_record['item_id'], $conn);
        $cost = $related_item['price'] * $raw_record['qty'];
        return $carry + $cost;
    }, 0);
}