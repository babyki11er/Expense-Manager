<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";
_main();

function _mod_validate(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        error("only accepting POST request");
    }
    if (!isset($_POST['attr']) || !isset($_POST['id'])) {
        error("Missing certain parameters");
        $attr = $_POST['attr'];
    }
    if (!in_array($attr, VALID_ATTRIBUTES)) {
        error("Invalid attr parameter value");
    }
    error("Don't know what the hell happened. I am not supposed to be reached!", 400, $_POST);
}
function _main(): void
{
    _mod_validate();
    $attr = $_POST['attr'];
    if ($attr === CATEGORY) {
        html_print_r($_POST);
        // _mod_category();
    }
    error("Don't know what the hell happened. I am not supposed to be reached!", 400, $_POST);
}

function _mod_category(): void
{
    $id = $_POST['id'];
    $newName = $_POST['value'];
    // do some validation
    if (empty($newName)) {
        error("Value cannot be empty");
    }
    if (($ecode = modifyCategory($id, $newName)) > 0) {
        redirect("category.php");
    } else if ($ecode === -4) {
        error("Invalid request parameters");
    } else if ($ecode === -1) {
        error("Error storing the result");
    }
}
