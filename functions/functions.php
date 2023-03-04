<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/globals.php";

// $valid_selecteds = ['item', 'category', 'record'];
/* data structure */

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_category.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_item.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_record.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_income.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_archive.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_db.php";

/* utilities */
/*
    general functions don't have Camel Casing
*/

function error(string $message, int $status_code = 400, array $debug = null): void
{
    if ($debug) {
        $array = $debug;
    } else {
        $array = [];
    }
    $array['error_message'] = $message;
    _api_header();
    http_response_code($status_code);
    die(json_encode($array));
}

/*
    for getting duplicates, we count the occurence of each value, then, filter it, and return the keys, easy task, just a matter of finding which functions to call
*/
function get_duplicates(array $arr, string $col) : array
{
    $values = array_column($arr, $col);
    $counts = array_count_values($values);
    $duplicate_counts = array_filter($counts, function($val) {
        return $val > 1;
    });
    $duplicates = array_keys($duplicate_counts);
    return $duplicates;
}

function displayMoney(int $money) : string
{
    return number_format($money);
}

function displayItem(array $item) : string
{
    $r_item = $item['name'];
    if ($item['duplicate']) {
        $r_item .= ' : ' . displayMoney($item['price']);
    }
    return $r_item;
}

function _api_header(): void
{
    header("Content-type: application/json");
}

function _html_header(): void
{
    header("Content-type: text/html");
}

function _html_log(string $s) : void
{
    echo '<h4 class="log">';
    echo $s;
    echo "</h4>";
}

function redirect(string $php_file): void
{
    header("Location: /$php_file");
    die();
}

// proud of this 2 functions, very neat i think
function getOrder(string $selected, string $backup) : string
{
    if (in_array($selected, VALID_SELECTORS)) {
        $key = "order-$selected";
        return _ssGet($key, $backup);
    }
    return $backup;
}

function setOrder(string $selected, string $val) : void
{
    $validOrderValues = [
        CATEGORY => ['id', 'name'],
        ITEM => ['id', 'name', 'price', 'cat_id'],
        RECORD => ['id', 'date']
    ];
    if (in_array($val, $validOrderValues[$selected])) {
        $key = "order-$selected";
        _ssSet($key, $val);
    }
}

function _ssGet(string $key, string $default) : string
{
    $val = $_SESSION[$key] ?? $default;
    return $val;
}

function _ssSet(string $key, string $val) : void
{
    $_SESSION[$key] = $val;
}

/* dev */

function dd($data, $showType = false, $die = true): void
{
    echo "<pre style='background-color: #1d1d1d;color: #cdcdcd; padding: 20px; margin: 10px; border-radius: 10px; line-height: 1.2rem;'>";
    if ($showType) {
        var_dump($data);
    } else {
        print_r($data);
    }
    echo  "</pre>";
    if ($die) {
        die();
    }
}

function LogConsole(string $message): void
{
    noti($message);
    error_log("\033[34m ******** $message ******\033[0m", 4);
    file_put_contents("php://stderr", print_r(""));
}

function apiResponse(array $arr): void
{
    _api_header();
    die(json_encode($arr));
}

function html_h4(string $s): void
{
    echo "<h4>[ $s ]</h4>";
}

// play audio if a fatal error is thrown
function slayer(): void
{
    exec("mpg123 /home/linn8/Music/dead.mp3");
}

function noti($message): void
{
    exec("notify-send \"****** $message ******\"");
}

function shutDownFunction()
{
    $error = error_get_last();
    // Fatal error, E_ERROR === 1
    if (isset($error['type']) && $error['type'] === E_ERROR) {
        // Do your stuff
        //  LogConsole("****** FATAL ERROR *******");
        //  slayer();
        noti("FATAL ERROR");
    }
}
register_shutdown_function('shutDownFunction');
