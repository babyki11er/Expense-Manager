<?php
/*
    Item:
        name    string
        price   int
        cat-id  int
        [public view]
        cat-str string
    Interface:
        getItemsPublic()    => item arrays, with category name for showing
        getItem($id)        => item array, no cat-str
        addNewItem($name, $price, $cat_id)  => new added id
        deleteItem($id)     => boolean on success
*/

// returns items to display
function getItemsPublic(): array
{
    $items = _readAllItems();
    // filtering archive items
    $archive_items = _getArchiveItems();
    foreach ($archive_items as $id) {
        unset($items[$id]);
    }
    // constructing the array to display
    $items_public = array_map(function ($item) {
        $item['cat-str'] = getCategory($item['cat-id']);
        return $item;
    }, $items);
    return $items_public;
}

function getItemsByCatId(int $id): array
{
    // returns array of id, not item array
    $all_items = _readAllItems();
    $selected_items = array_filter($all_items, function ($v) use ($id) {
        return $v['cat-id'] == $id;
    });
    return array_keys($selected_items);
}

function getItem($id): array
{
    if (!_validateItem($id)) {
        return NOT_EXIST;
    }
    $all_items = _readAllItems();
    return $all_items[$id];
}

function addNewItem(string $name, int $price, int $cat_id): int
{
    $new_item = [
        'name' => $name,
        'price' => $price,
        'cat-id' => $cat_id
    ];
    $existing_items = _readAllItems();
    $r_id = count($existing_items);
    $existing_items[] = $new_item;
    if (_saveItems($existing_items)) {
        return $r_id;
    } else {
        return -1;
    }
}

function archiveItem(int $id): int
{
    // do some validation
    if (!_validateItem($id)) {
        return -4;
    }
    return _archive($id, ITEM);
}

function _validateItem(int $id): bool
{
    $active_items = _readAllItems();
    return array_key_exists($id, $active_items);
    // if (!array_key_exists($id, $active_items)) {
    //     return -4;
    // }
}
function _getArchiveItems(): array
{
    return _getArchives(ITEM);
}

function _readAllItems(): array
{
    return _getDataFromFileName(ITEM_FN);
}

function _saveItems(array $items): bool
{
    return _writeDataToFile(ITEM_FN, $items);
}
