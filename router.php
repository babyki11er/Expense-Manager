<?php
// routing
$uri = $_SERVER["REQUEST_URI"];
$path = parse_url($uri)['path'];
if ($path === '/') {
    $path .= 'index';
}
// echo $path . "<br>";

const Apis = [
    'add', 
    'archive',
    'del',
    'update',
    'get-one'
];

const Pages = [
    '/index' => "index@main",

    '/records' => "record@list_",
    '/record/add' => "record@add",
    '/record/edit' => "record@edit",

    '/incomes' => "income@list_",
    '/income/add' => "income@add",
    '/income/edit' => "income@edit",

    '/items' => "item@list_",
    '/item/add' => "item@add",
    '/item/edit' => "item@edit",

    '/categories' => "category@list_",
    '/category/add' => "category@add",
    '/category/edit' => "category@edit",
];

if (substr($path, 0, 5) == '/api/') {
    $api_name = substr($path, 5);
    if (in_array($api_name, Apis)) {
        require_once ROOT_DIR . '/api-controller.php';
        return;
    }
}

if (array_key_exists($path, Pages)) {
    pass_control_to(Pages[$path]);
    return;
}

if ($path === '/test') {
    view("/beer");
    return;
}
view("/404");
