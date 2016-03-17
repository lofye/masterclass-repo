<?php

namespace Masterclass\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;

class DiConfig extends Config
{
    public function define(Container $di)
    {
        $config = $di->get('config');

        $db = $config['database'];

        $dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

        $di->params['Masterclass\Dbal\AbstractDb'] = [
            'dsn' => $dsn,
            'user' => $db['user'],
            'pass' => $db['pass'],
        ];

        $di->params['Masterclass\Controllers\FrontController'] = [
            'container' => $di,
            'config' => $config,
            'router' => $di->lazyNew('Masterclass\Router\Router'),
        ];

        $di->params['Masterclass\Controllers\Index'] = [
            'storyModel' => $di->lazyNew('Masterclass\Models\Story'),
        ];

        $di->params['Masterclass\Controllers\Comment'] = [
            'commentModel' => $di->lazyNew('Masterclass\Models\Comment'),
        ];

        $di->params['Masterclass\Models\Comment'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];

        $di->params['Masterclass\Controllers\Story'] = [
            'storyModel' => $di->lazyNew('Masterclass\Models\Story'),
            'commentModel' => $di->lazyNew('Masterclass\Models\Comment'),
        ];

        $di->params['Masterclass\Models\Story'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];

        $di->params['Masterclass\Controllers\User'] = [
            'config' => $di->lazyNew('Masterclass\Models\User'),
        ];

        $di->params['Masterclass\Models\User'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];
    }
}