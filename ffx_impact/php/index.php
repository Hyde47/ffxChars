<?php

// Get the requested URL path
$request_uri = $_SERVER['REQUEST_URI'];
echo $request_uri;

$routes = [
    '/api/getActiveChar' => './function/getActiveChar.php'
];
if (array_key_exists($request_uri, $routes)) {
    include $routes[$request_uri];
} else {
    http_response_code(404);
    echo '404 Page Not Found test';
}