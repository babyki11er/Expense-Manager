<?php
// routing
$uri = $_SERVER["REQUEST_URI"];
$path = parse_url($uri)['path'];
// echo $path . "<br>";


const ValidApis = [
    'add',
    'archive',
    'del',
    'get-one',
    'update'
];
const ValidRoutes = [
    '/category',
    '/error',
    '/income',
    '/index',
    '/insert',
    '/item',
    '/records',
    '/test',
    
    '/'
];
if (substr($path, 0, 5) == '/api/') {
    $api_name = substr($path, 5);
    if (in_array($api_name, ValidApis)) {
        require_once ROOT_DIR . '/api-controller.php';
        return;
    }
}
else if (in_array($path, ValidRoutes)) { // 
    require_once TEMPLATE_DIR . '/header.php';
    require_once PAGE_CONTROLLER . "$path.controller.php";
    // alert box here
    echo getNoti();
    require_once VIEW_DIR . "$path.view.php";
    require_once TEMPLATE_DIR . '/footer.php';
    view($path);
    return;
    // load the script
}
view("404");