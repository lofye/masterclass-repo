<?php

namespace Masterclass\Router\Routes;

class GetRoute extends AbstractRoute
{
    public function matchRoute($requestPath, $requestType)
    {
        if($requestType != 'GET'){
            return false;
        }

        if($this->routePath != $requestPath)
        {
            return false;
        }

        return true;
    }
}