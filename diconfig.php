<?php

$di = new Aura\Di\Container(new Aura\Di\Factory());

$db = $config['database'];

$dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

$di->params['PDO'] = [
    'dsn' => $dsn,
    'username' => $db['user'],
    'passwd' => $db['pass'],
];

$di->params['Masterclass\Controllers\FrontController'] = [
    'container' => $di,
    'config' => $config,
];

$di->params['Masterclass\Controllers\Comment'] = [
    'commentModel' => $di->lazyNew('Masterclass\Models\Comment'),
];

$di->params['Masterclass\Controllers\Story'] = [
    'storyModel' => $di->lazyNew('Masterclass\Models\Story'),
    'commentModel' => $di->lazyNew('Masterclass\Models\Comment'),
];

$di->params['Masterclass\Controllers\Index'] = [
    'storyModel' => $di->lazyNew('Masterclass\Models\Story'),
];

$di->params['Masterclass\Controllers\User'] = [
    'userModel' => $di->lazyNew('Masterclass\Models\User'),
];

$di->params['Masterclass\Models\Comment'] = [
    'pdo' => $di->lazyNew('PDO')
];

$di->params['Masterclass\Models\Story'] = [
    'pdo' => $di->lazyNew('PDO'),
];

$di->params['Masterclass\Models\User'] = [
    'pdo' => $di->lazyNew('PDO'),
];

