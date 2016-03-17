<?php

namespace Masterclass\Router\Routes;

interface RouteInterface
{
    public function matchRoute($requestPath, $requestType);

    public function getRoutePath();

    public function getRouteClass();
}