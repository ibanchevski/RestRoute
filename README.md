# RestRoute
Minimal PHP RESTful routes parser and dispatcher.
It helps building a simple RESTful routes with parameters
defined in curly brackets.
<br>
# Usage

```php
<?php
include "RestRoute/Router.php";

$router = new RestRoute\Router();

// Define routes with handler functions
$router->get('/api/users', 'handler_function');
$router->addRoute('GET', '/api/users/{name}', function($data) {
	echo "Get user with name: ".$data[0]."\n";
});


// Dispatch the current route
// (The example here is hardcoded)
$routeResults = $router->dispatch('GET', '/api/users/john');
$handler = $routeResults[0];
$params = $routeResults[1];

var_dump($handler);
var_dump($params);

// Run the handler with the parameters
$handler($params);

```