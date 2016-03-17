<?php

namespace Masterclass\Controllers;
use Aura\Di\Container as Container;
use Masterclass\Router\Router;

class FrontController {
    
    protected $config;
    protected $container;
    protected $router;

    public function __construct(Container $container, $config = [], Router $router) {
        $this->container = $container;
        $this->config = $config;
        $this->router = $router;
    }
    
    public function execute() {
        $match = $this->_determineRoute();
        $calling = $match->getRouteClass();
        list($class, $method) = explode(':', $calling);
        $o = $this->container->newInstance($class);//resolve it out of the DIC
        return $o->$method();
    }
    
    protected function _determineRoute()
    {
        $router = $this->router;
        $match = $router->findMatch();

        if(!$match){
            throw new \Exception('No route match found!');
        }

        return $match;
    }
    
}