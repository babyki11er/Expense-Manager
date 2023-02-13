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
}

// add a new record, returns the id
function addNewRecord(int $item_id, int $qty, string $date, string $note): int
{
    // do some validation
}

// function addNewRecordNewItem(string $item_name, int $item_price, int $item_cat_id, int $qty, string $date, string $note) : int
// {
//     $new_item_id = addNewItem($item_name, $item_price, $item_cat_id);
//     return addNewRecord($new_item_id, $qty, $date, $note);
// }

function deleteRecord(int $id): int
{
}

function _validateRecord(int $id): bool
{
    // validation not to fuck up the security
}
function _getTotalOutcome(): int
{
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
