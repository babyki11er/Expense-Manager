<?php
/*
    [[[[ TO DO ]]]]
    + create item first if the item doesn't exist
*/
/* Record:
        item-id int
        qty     int
        date    str
        note    str
    deleteRecord($id)   => compeletely remove from the data, no DELETED string is left at all
*/

function getRecordsPublic(): array
{
    $records = _readAllRecords();
    $front_end_records = [];
    foreach ($records as $id => $record) {
        $item = getItem($record['item-id']);
        $date = $record['date'];
        $item_name = $item['name'];
        $qty = $record['qty'];
        $cost = $item['price'] * $qty;
        $category = getCategory($item['cat-id']);
        $note = $record['note'];
        $view_record = [
            'date' => $date,
            'item-name' => $item_name,
            'qty' => $qty,
            'cost' => $cost,
            'category' => $category,
            'note' => $note

        ];
        $front_end_records[$id] = $view_record;
    }
    return $front_end_records;
}

// add a new record, returns the id
function addNewRecord(int $item_id, int $qty, string $date, string $note): int
{
    // do some validation
    $record_to_add = _makeRecord($item_id, $qty, $date, $note);
    $all_records = _readAllRecords();
    $r_id = count($all_records);
    $all_records[] = $record_to_add;
    if (_saveRecords($all_records)) {
        return $r_id;
    } else {
        return -1;
    }
}

// function addNewRecordNewItem(string $item_name, int $item_price, int $item_cat_id, int $qty, string $date, string $note) : int
// {
//     $new_item_id = addNewItem($item_name, $item_price, $item_cat_id);
//     return addNewRecord($new_item_id, $qty, $date, $note);
// }

function deleteRecord(int $id): int
{
    if (!_validateRecord($id)) {
        return -4;
    }
    $all_records = _readAllRecords();
    // actual deletion
    array_splice($all_records, $id, 1);

    if (_saveRecords($all_records)) {
        return $id;
    } else {
        // deletion has not been successful due to saving file error
        return -1;
    }
}

function _validateRecord(int $id): bool
{
    // validation not to fuck up the security
    $all_records = _readAllRecords();
    if ($id < 0 || $id >= count($all_records)) {
        // id is likely malicious
        return false;
    }
    // this normally shouldn't happen as we don't accept gaps in the array but can't tell
    if (!array_key_exists($id, $all_records)) {
        // id doesn't exist
        noti("Gap in record array!");
        slayer();
        return false;
    }
    return true;
}

// function _getRecordById(int $id): array
// {
//     $active_records = _getActiveRecords();
//     if (!array_key_exists($id, $active_records)) {
//         return DELETED;
//         // the record is either deleted or doesn't exist
//     }
//     return $active_records[$id];
// }

function _getTotalOutcome(): int
{
    $records = getRecordsPublic();
    $total = 0;
    foreach ($records as $record) {
        $total += $record['cost'];
    }
    return $total;
}

function _makeRecord(int $item_id, int $qty, string $date, string $note): array
{
    $r_record =
        [
            'item-id'   =>  $item_id,
            'qty'       =>  $qty,
            'date'      =>  $date,
            'note'      =>  $note
        ];
    return $r_record;
}
function _saveRecords($all_records): bool
{
    return _writeDataToFile(RECORD_FN, $all_records);
}

function _readAllRecords(): array
{
    return _getDataFromFileName(RECORD_FN);
}
