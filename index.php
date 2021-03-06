<?php

include "RestRoute/Router.php";

$router = new RestRoute\Router();

$router->addRoute('GET', '/api/users', function() {
    echo "Get all users\n";
});

$router->addRoute('GET', '/api/users/{name}', function($data) {
    echo "Get user with name: ".$data['name']."\n";
});

$routeResults = $router->dispatch('GET', '/api/users/john');
$handler = $routeResults[0];
$params = $routeResults[1];

var_dump($handler);
var_dump($params);

$handler($params);
