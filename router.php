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
        api_controller($api_name);
        return;
    }
}
else if (in_array($path, ValidRoutes)) {
    view($path);
    return;
    // load the script
}
view("404");