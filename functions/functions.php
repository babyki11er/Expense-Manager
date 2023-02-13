<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/globals.php";

// $valid_attributes = ['item', 'category', 'record'];
/* data structure */

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_category.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_item.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_record.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_income.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/fn_archive.php";

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

function _getColumnNameFromAttribute(string $attribute): string
{
    if ($attribute === 'item') {
        return $attribute;
    }
    if ($attribute === 'category') {
        return 'cat';
    }
    if ($attribute === 'record') {
        return 'rcrd';
    }
}

function _api_header(): void
{
    header("Content-type: application/json");
}

function _html_header(): void
{
    header("Content-type: text/html");
}

function redirect(string $php_file): void
{
    header("Location: /$php_file");
    die();
}

/* dev */

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

function html_var_dump($var): void
{
    echo "<pre >";
    var_dump($var);
    echo "</pre>";
}

function html_print_r(array $arr): void
{
    echo "<pre >";
    var_dump($arr);
    echo "</pre>";
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

/* internal data storage */
function _getDataFromFileName(string $file_name): array
{
    $file_name = $_SERVER['DOCUMENT_ROOT'] . "/$file_name";
    if (!file_exists($file_name)) {
        touch($file_name);
        noti("$file_name doesn't exist! Something is terribly wrong");
        slayer();
        return [];
    }
    $json_string = file_get_contents($file_name);
    $array = json_decode($json_string, true);
    return $array;
}

function _writeDataToFile(string $file_name, array $data): bool
{
    $json_string = json_encode($data);
    return file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $file_name, $json_string);
}
