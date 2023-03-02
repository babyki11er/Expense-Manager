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

function _getColumnNameFromAttribute(string $selected): string
{
    if ($selected === 'item') {
        return $selected;
    }
    if ($selected === 'category') {
        return 'cat';
    }
    if ($selected === 'record') {
        return 'rcrd';
    }
}

function display_money(int $money) : string
{
    return number_format($money);
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
