<?php
// routing
$uri = $_SERVER["REQUEST_URI"];
$path = parse_url($uri)['path'];
if ($path === '/') {
    $path .= 'index';
}
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
    // '/index',
    '/insert',
    '/item',
    '/records',
    '/test'
];
const ValidPaths = [
    '/index'
];
if (substr($path, 0, 5) == '/api/') {
    $api_name = substr($path, 5);
    if (in_array($api_name, ValidApis)) {
        require_once ROOT_DIR . '/api-controller.php';
        return;
    }
} else if (in_array($path, ValidRoutes)) {

    // trash code just to not have a broken app, will be updated soon
    require_once TEMPLATE_DIR . '/header.php';
    require_once PAGE_CONTROLLER . "$path.controller.php";
    // alert box here
    echo getNoti();
    require_once VIEW_DIR . "$path.view.php";
    require_once TEMPLATE_DIR . '/footer.php';
    view($path);
    return;
} else if (in_array($path, ValidPaths)) {
    // giving all the control to the router because it's simpler
    // 'controller' here merely exist to provide variables for rendering the view
    load_controller($path);
    $data = run_controller();
    echo "this is updated version yo";
    view($path, $data);
    return;
    // load the script
}
view("/404");
