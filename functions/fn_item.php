<?php
/*
    Item:

        id      int
        name    string
        price   int
        cat_id  int
        cat_str string



    Interface:
        getItemsPublic()    => item arrays, with category name for showing
        getItem($id)        => item array, no cat_str
        addNewItem($name, $price, $cat_id)  => new added id
        deleteItem($id)     => boolean on success
*/

// returns items to display
function listItems(mysqli $conn): array
{
    $raw_items = db_SelectAll($conn, ITEM, ['status' => 'active']);
    return array_map(function ($item) use ($conn) {
        $item['cat_str'] = getCategoryName($item['cat_id'], $conn);
        return $item;
    }, $raw_items);
}

function getItemNames(mysqli $conn): array
{
    $raw_item_names = db_SelectAll($conn, ITEM, ['status' => 'active'], 'name');
    return $raw_item_names;
}

function getItemsByCategory(int $cat_id, mysqli $conn): array
{
    $raw_items = db_SelectAll($conn, ITEM, ['cat_id' => $cat_id]);
    return array_map(function ($item) use ($conn) {
        $item['cat_str'] = getCategoryName($item['cat_id'], $conn);
        return $item;
    }, $raw_items);
}

// function getItemsByCatId(int $id): array
// {
//     // returns array of id, not item array
// }

function getItemById(int $id, mysqli $conn): array
{
    $raw = db_SelectOne($conn, ITEM, ['id' => $id]);
    if (is_null($raw)) {
        return [];
    }
    $raw['cat_str'] = getCategoryName($raw['cat_id'], $conn);
    return $raw;
}

function addNewItem(string $name, int $price, int $cat_id, mysqli $conn): int
{
    if ($price < 0) {
        return VALIDATE_ERROR;
    }
    $item_to_add = _makeItem($name, $price, $cat_id);
    return db_Insert($conn, ITEM, $item_to_add);
}

function updateItem(int $id, string $name, int $price, int $cat_id, mysqli $conn) : int
{
    if (!_checkItem($id, $conn)) {
        return VALIDATE_ERROR;
    }
    $update_value = _makeItem($name, $price, $cat_id);
    return db_Update($conn, ITEM, $id, $update_value);
}

function _checkItem(int $id, mysqli $conn) : bool
{
    // do some vaildations? idk
    $fetched = db_SelectOne($conn, ITEM, ['id' => $id], 'id');
    return !is_null($fetched);
}

function archiveItem(int $id, mysqli $conn, bool $archived=true): int
{
    $id = db_Update($conn, ITEM, $id, ['status' => 'archived']);
    return $id;
    // do some validation, then db function
}

function _makeItem(string $name, int $price, int $cat_id) : array
{
    return [
        'name' => $name,
        'price' => $price,
        'cat_id' => $cat_id
    ];
}

// function _validateItem(int $id): bool
// {
// }
// function _getArchiveItems(): array
// {
//     return _getArchives(ITEM);
// }
