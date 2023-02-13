<?php
// require_once "./functions.php";

const CATEGORY = 'category';
const ITEM = 'item';
const RECORD = 'record';
const INCOME = 'income';
const CATEGORY_FN = 'categories.json';
const ITEM_FN = 'items.json';
const RECORD_FN = 'records.json';
const INCOME_FN = 'incomes.json';
const DELETED = 'DELETED';
const ARCHIVE = 'archives.json';
const NOT_EXIST = 'idk';
const VALID_ATTRIBUTES = [CATEGORY, ITEM, RECORD, INCOME];


// create the files
if (!file_exists(CATEGORY_FN)) {
    // fix later
    // created the file with nothing at all, maybe something to do with touch, idk
    touch(CATEGORY_FN);
    $cats = ['None'];
    _writeDataToFile(CATEGORY_FN, $cats);
}

if (!file_exists(ITEM_FN)) {
    touch(ITEM_FN);
    _writeDataToFile(ITEM_FN, []);
}

if (!file_exists(RECORD_FN)) {
    touch(RECORD_FN);
    _writeDataToFile(RECORD_FN, []);
}

if (!file_exists(INCOME_FN)) {
    touch(INCOME_FN);
    _writeDataToFile(INCOME_FN, []);
}

if (!file_exists(ARCHIVE)) {
    touch(ARCHIVE);
    _writeDataToFile(ARCHIVE, [CATEGORY => [], ITEM => [], RECORD => []]);
}
