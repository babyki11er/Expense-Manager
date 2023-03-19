<?php
// routing
$uri = $_SERVER["REQUEST_URI"];
$path = parse_url($uri)['path'];
echo $path . "<br>";

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

const ValidApis = [
    'add',
    'archive',
    'del',
    'get-one',
    'update'
];

if (in_array($path, ValidRoutes)) {
    view($path);
    // load the script
    
} else if (in_array($path, ValidApis)) {
    // api will simply require the file for now, yellow
    require_once API_DIR . "$path-api.php";
} else {
    // 404 page
    view("404");
}