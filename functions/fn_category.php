<?php
/*
    Categories:
        no attribute, it is just a dumb string
    Properties:
        name    string
        price   int
        cat-id  int (foregin key)
    Public interface:
        listCategories();  => array with id as index
            filtered archive items for public view
        getCategory($id);   => category name string
        addNewCategory($id);    => id of the added category
        archiveCategory($id);   => int
*/


function listCategories(): array
// returns categories available to use in coming items
{
    $all_categories = _readAllCategories();
    // removing archived values
    $archive_categories = _getArchives(CATEGORY);
    foreach ($archive_categories as $id) {
        unset($all_categories[$id]);
    }
    return $all_categories;
}

function getCategory(int $id): string
{
    if (_validateCategory($id)) {
        $cats = _readAllCategories();
        return $cats[$id];
    } else {
        // id doesn't exist
        return -4;
    }
}

function addNewCategory(string $category): int
{
    $existing_cats = _readAllCategories();
    if (in_array($category, $existing_cats)) {
        return -4;
    }
    $r_id = count($existing_cats);
    $existing_cats[] = $category;
    if (_saveCategories($existing_cats)) {
        return $r_id;
    } else {
        return -1;
    }
}

function archiveCategory(int $id): int
{
    if (!_validateCategory($id)) {
        return -4;
    }
    // first archiving items related to category
    $related_items = getItemsByCatId($id);
    foreach ($related_items as $item_id) {
        archiveItem($item_id);
    }
    // finally archiving the id
    if (_archive($id, CATEGORY)) {
        return $id;
    } else {
        return -1;
    }
}

function modifyCategory(int $id, string $newName): int
{
    // validate the arguments
    if (!_validateCategory($id)) {
        return -4;
    }
    $all_categories = _readAllCategories();
    if ($all_categories[$id] === $newName) {
        return -4;
    }
    $all_categories[$id] = $newName;
    if (_saveCategories($all_categories)) {
        return $id;
    } else {
        return -1;
    }
}

function _validateCategory(int $id): bool
{
    $valid_cats = _readAllCategories();
    return array_key_exists($id, $valid_cats);
}


function _readAllCategories(): array
{
    return _getDataFromFileName(CATEGORY_FN);
}

function _saveCategories(array $all_categories): bool
{
    return _writeDataToFile(CATEGORY_FN, $all_categories);
}
