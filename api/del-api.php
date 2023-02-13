<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";
// html_print_r($_GET);
// die();
_main();

function _validateRequestParams(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        error("only accepting GET method");
    }
    // TODO: combine all 3 into one condition
    if (!isset($_GET['id'])) {
        error("Not setting 'id' param. Don't fuck with delete api!");
    }
    if (!isset($_GET['del'])) {
        error("Not setting del parameter. Did you call me mistakenly? Don't fuck with delete api!");
    }
    if (!isset($_GET['attr'])) {
        error("Not setting 'attr' param. Don't fuck with delete api!");
    }
    if (!is_numeric($_GET['id'])) {
        error("id parameter has to be a number. don't fuck with delete api!");
    }
    $attribute_to_del = $_GET['attr'];
    if (!in_array($attribute_to_del, VALID_ATTRIBUTES)) {
        error("Invalid 'attr' param.");
    }
}
function _record(): void
{
    $id = (int)$_GET['id'];
    // do some validations
    if (($e_code = deleteRecord($id)) >= 0) {
        redirect('./records.php');
    } else {
        switch ($e_code) {
            case '-1':
                error("deletion failed due to error on writing to the storage. Please, try again");
                break;
            case '-4':
                error("record you are trying to delete do not exist.");
                break;
            case '-5':
                error("record you are deleting has already been deleted");
                break;
            case '-8':
                error("fuck off, hecker!");
                break;
        }
    }
}


function _main(): void
{
    /*
            DELETEING CATEGORY
        */
    _validateRequestParams();
    $attribute_to_del = $_GET['attr'];

    if ($attribute_to_del === CATEGORY) {
        _category();
    }

    /*
            DELETING ITEM
        */
    if ($attribute_to_del === ITEM) {
        _item();
    }

    /*
            DELETING RECORD
        */
    if ($attribute_to_del === RECORD) {
        _record();
    }
}
