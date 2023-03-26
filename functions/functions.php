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
function view(string $path, array $data = null): void
{
    // asssume that path is already valid

    // loading the data
    // array to variable
    if (!is_null($data)) {
        foreach ($data as $key => $value) {
            // dynamic variable name, will be sanitizing for XSS later
            ${$key} = $value;
        }
    }
    require_once TEMPLATE_DIR . '/header.php';
    // alert box here
    echo getNoti();
    require_once VIEW_DIR . "/$path.view.php";
    require_once TEMPLATE_DIR . '/footer.php';
    return;
}

function load_controller(string $page): void
{
    // assume that page is already valid
    require_once PAGE_CONTROLLER . "$page.controller.php";
    return;
}

// MVC controller part
function pass_control_to(string $controller): void
{
    $conn = connectMysql();
    $controller_array = explode('@', $controller);
    $controller_file = $controller_array[0];
    $controller_function = $controller_array[1];
    require_once PAGE_CONTROLLER . "/$controller_file.controller.php";
    call_user_func($controller_function, $conn);
}

// very general function for all the validation of HTTP request, neat, i think
// exit giving an error
function validate_isset_http(string $req_method, array $set_us): void
{
    if ($_SERVER['REQUEST_METHOD'] == $req_method) {
        $invalid_params = [];
        $array = $req_method == "POST" ? $_POST : $_GET;
        foreach ($set_us as $param) {
            if (empty($array[$param])) {
                $invalid_params[] = $param;
            }
        }
        if (empty($invalid_params)) {
            // the request has been passed the validation test
            return;
        }
        error("Not setting or empty parameters: " . implode(",", $invalid_params));
    }
    error("This is not a $req_method api!", 400);
}

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

function back_to_referer($message = null, $removeQueries = true): void
{
    $referer = $_SERVER['HTTP_REFERER'];
    if ($removeQueries) {
        // shallow logic, yellow
        $referer = explode("?", $referer)[0];
    }
    if (!is_null($message)) {
        setNoti($message);
    }
    redirect($referer);
}

// alert box here
// returns the whole noti html, not just the Session data
function getNoti(): string
{
    if (is_null($_SESSION['noti'])) {
        return '';
    }
    $noti = $_SESSION['noti'];
    $html = alert($noti['message']);
    $_SESSION['noti'] = null;
    return $html;
}

function setNoti(string $message): void
{
    $_SESSION['noti']['message'] = $message;
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

function alert(string $message, string $color = "success"): string
{
    return "<div class=' alert alert-$color'>$message</div>";
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
