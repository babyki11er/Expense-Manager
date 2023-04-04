<?php
/*
    ALL THESE FUNCTIONS DEAL WITH RECORDS, VALIDATE ACCORDING TO THE RECORD RULES AND nothing else!
*/
/* Record:

        item_id     int
        item_name   string(computed)
        qty         int
        cost        int(computed)
        cat_str     string(computed)
        cat_id      int(computed)
        date        str
        note        str
*/

function _makeRecord(int $item_id, int $qty, string $date, string $note): array
{
    return [
        'item_id' => $item_id,
        'qty' => $qty,
        'date' => $date,
        'note' => $note
    ];
}

function listRecords(mysqli $conn, int $month = 0): array
{
    $order = getOrder(RECORD, 'date');
    if ($order === 'qty' || $order === 'note')
        $order .= ' DESC ';
    if (empty($month)) {
        $raw_records = db_SelectAll($conn, RECORD, [], '*', $order);
    } else {
        // yellow, of course
        $raw_records = db_SelectAll($conn, RECORD, ['month(date)' => $month], '*, date_format(date, "%a") as day_name, day(date) as day', $order);
    }
    return is_null($raw_records) ? [] :
        array_map(function ($raw) use ($conn) {
            $record_public = $raw;
            $related_item_id = $raw['item_id'];
            $related_item = getItemById($related_item_id, $conn);
            // computed
            $record_public['item_name'] = $related_item['name'];
            $record_public['cost'] = $related_item['price'] * $raw['qty'];
            $record_public['cat_str'] = $related_item['cat_str'];
            $record_public['cat_id'] = $related_item['cat_id'];
            return $record_public;
        }, $raw_records);
}

function getRecord(mysqli $conn, int $id): array
{
    // yellow, there is no strict rule on what makes of a record, inconsistant shapes of data
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
    $record_to_add = _makeRecord($item_id, $qty, $date, $note);
    return db_Insert($conn, RECORD, $record_to_add);
}

function updateRecord(int $id, int $item_id, int $qty, string $date, string $note, mysqli $conn): bool
{
    if (_checkRecord($id, $conn)) {
        $record_to_add = _makeRecord($item_id, $qty, $date, $note);
        return db_Update($conn, RECORD, $record_to_add, ['id' => $id]);
    }
    return false;
}

function _checkRecord(int $id, mysqli $conn): bool
{
    return !is_null(db_SelectOne($conn, RECORD, ['id' => $id], 'id'));
}

function deleteRecord(int $id, mysqli $conn): bool
{
    if (_checkRecord($id, $conn)) {
        return db_Delete($conn, RECORD, $id);
    }
    return false;
}

// yellow?
function getTotalOutcome(mysqli $conn, int $month = 0): int
{
    if (empty($month)) {
        $raw_records = db_SelectAll($conn, RECORD, []);
    } else {
        $raw_records = db_SelectAll($conn, RECORD, ['month(date)' => $month]);
    }
    return is_null($raw_records) ? 0 :
        array_reduce($raw_records, function ($carry, $raw_record) use ($conn) {
            $related_item = getItemById($raw_record['item_id'], $conn);
            $cost = $related_item['price'] * $raw_record['qty'];
            return $carry + $cost;
        }, 0);
}
