<?php

namespace RestRoute;

class Route {
    /** @var string */
    private $httpMethod;

    /** @var string */
    private $regex;

    /** @var mixed */
    private $handler;

    /** @var mixed */
    private $routeParams;

    /**
     * @param string $httpMethod
     * @param string $regex
     * @param mixed  $handler
     */
    public function __construct($httpMethod, $regex, $handler, $routeParams)
    {
        $this->httpMethod = $httpMethod;
        $this->regex = $regex;
        $this->handler = $handler;
        $this->routeParams = $routeParams;
    }

    /**
     * Get the route params as an object
     * @return mixed ["method", "regex", "handler"]
     */
    public function get() {
        return [
            "method" => $this->httpMethod,
            "regex" => $this->regex,
            "handler" => $this->handler,
            "routeParams" => $this->routeParams
        ];
    }
}
