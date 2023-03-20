<?php

// ROOT_DIROOT'];
require_once ROOT_DIR . "/globals.php";
require_once ROOT_DIR . "/functions/fn_category.php";
require_once ROOT_DIR . "/functions/fn_item.php";
require_once ROOT_DIR . "/functions/fn_record.php";
require_once ROOT_DIR . "/functions/fn_income.php";
require_once ROOT_DIR . "/functions/fn_db.php";

/*
    business logic?
*/
function get_duplicates(array $arr, string $col): array
{
    // for getting duplicates, we count the occurence of each value, then, filter it, and return the keys, easy task, just a matter of finding which functions to call
    $values = array_column($arr, $col);
    $counts = array_count_values($values);
    $duplicate_counts = array_filter($counts, function ($val) {
        return $val > 1;
    });
    $duplicates = array_keys($duplicate_counts);
    return $duplicates;
}

// proud of this 2 functions, very neat i think
function getOrder(string $selected, string $backup): string
{
    if (in_array($selected, VALID_SELECTORS)) {
        $key = "order-$selected";
        return _ssGet($key, $backup);
    }
    return $backup;
}

function setOrder(string $selected, string $val): void
{
    $validOrderValues = [
        CATEGORY => ['id', 'name'],
        ITEM => ['id', 'name', 'price', 'cat_id'],
        RECORD => ['id', 'date', 'item_id', 'qty']
    ];
    if (in_array($val, $validOrderValues[$selected])) {
        $key = "order-$selected";
        _ssSet($key, $val);
    }
}

function displayMoney(int $money): string
{
    return number_format($money);
}

function displayItem(array $item): string
{
    $r_item = $item['name'];
    if ($item['duplicate']) {
        $r_item .= ' : ' . displayMoney($item['price']);
    }
    return $r_item;
}

/* utilities */
/*
    general functions don't have Camel Casing
*/

// MVC view part
function view(string $path): void
{
    // asssume that path is already valid
    if ($path === '/') {
        view("index");
        return;
    }
    require_once VIEW_DIR . "$path.view.php";
}
// MVC controller part
// not using this
// function api_controller(string $name): void
// {
//     $controllerNameArray = explode("@", $name);
//     $controller_file = $controllerNameArray[0];
//     $controller_function = $controllerNameArray[1];
//     require_once API_DIR . "/$controller_file-api.php";
//     call_user_func($controller_function);
//     // assume that path is already valid
// }

// very general function for all the validation of HTTP request
// function validate_http_params(array $set_us, string $req_method="POST") : bool
// {

// }

function apiResponse(array $arr): void
{
    _api_header();
    die(json_encode($arr));
}


function redirect(string $location): void
{
    header("Location: $location");
    die();
}

function back_to_referer(bool $removeQueries = true): void
{
    $referer = $_SERVER['HTTP_REFERER'];
    if ($removeQueries) {
        // shallow logic, yellow
        $referer = explode("?", $referer)[0];
    }
    redirect($referer);
}

function _ssGet(string $key, string $default): string
{
    $val = $_SESSION[$key] ?? $default;
    return $val;
}

function _ssSet(string $key, string $val): void
{
    $_SESSION[$key] = $val;
}


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

function _api_header(): void
{
    header("Content-type: application/json");
}

function _html_header(): void
{
    header("Content-type: text/html");
}

function _html_log(string $s): void
{
    echo '<h4 class="log">';
    echo $s;
    echo "</h4>";
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
