<?php

namespace RestRoute;

include "Route.php";

class Router {
    private $routes = [];

    public function __construct()
    {
        // Initialize the groups of the routes
        // based on the http request type
        // Example:
        // GET:
        //   /api/users
        //   /api/users/{nam}
        // POST:
        //   /api/users
        $this->routes['GET'] = [];
        $this->routes['POST'] = [];
        $this->routes['DELETE'] = [];
    }

    public function addRoute($httpMethod, $uri, $handler) {
        // Convert route string to regex string
        $regex = $this->buildRegexOfUri($uri);

        // Save the names of the route parameters (if any)
        $routeParams = [];
        if (preg_match_all('/\{(.*?)\}/', $uri, $matches)) {
            $routeParams = $matches[1];
        }

        // Create the route object to hold the data 
        // for the route (method,regex,handler)
        // and append it to the global routes array
        $route = new Route($httpMethod, $regex, $handler, $routeParams);
        array_push($this->routes[$httpMethod], $route->get());
    }


    /**
     * Transform URI string into a regex
     * e.g /users/{name} -> /users/(\w+) 
     * @param string $uri
     * @return string regex
     */
    private function buildRegexOfUri($uri) {
        // Replace defined params {}
        // with a regex group (\w+)
        $replaced = preg_replace('/{\w+}/', '(\w+)', $uri);

        // Escape the / in the route
        $replaced = str_replace('/', '\/', $replaced);

        return "/".$replaced."/";
    }


    /** Define GET route */
    public function get($uri, $handler) {
        $this->addRoute('GET', $uri, $handler);
    }

    /** Define POST route */
    public function post($uri, $handler) {
        $this->addRoute('POST', $uri, $handler);
    }

    /** Define DELETE route */
    public function delete($uri, $handler) {
        $this->addRoute('DELETE', $uri, $handler);
    }

    /**
     * Dispatches URI based  on HTTP method
     * and returns the route handler and parameters.
     * @param string $httpMethod
     * @param string $uri
     * @return mixed [$handler, $vars]
     */
    public function dispatch($httpMethod, $uri) {
        // This $httpMethod routes
        $routesCategory = $this->routes[$httpMethod];
        $handler = null;
        $vars = [];

        foreach ($routesCategory as $route) {
            // Check which regex matches the route
            if (!preg_match($route['regex'], $uri, $matches)) {
                continue;
            }

            $handler = $route['handler'];
            $vars = array_slice($matches, 1);

            // Build named params array by using the names defined in the route
            $namedParams = [];
            for ($i = 0; $i < count($route['routeParams']); $i++) {
                $namedParams[$route['routeParams'][$i]] = $vars[$i];
            }
        }
        return [$handler, $namedParams];
    }

}
