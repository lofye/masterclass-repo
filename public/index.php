<?php

session_start();

$path = realpath(__DIR__.'/..');

require_once $path.'/vendor/autoload.php';

$config = function() use ($path) {
    $config = array();
    $config['path'] = $path;
    require_once $path.'/config.php';
    require_once $path.'/routes.php';
    return $config;
};

$diContainerBuilder = new \Aura\Di\ContainerBuilder();
$di = $diContainerBuilder->newInstance(['config' => $config],
                                       ['Masterclass\Configuration\DiConfig',
                                        'Masterclass\Configuration\RouterConfig']);

$framework = $di->newInstance('Masterclass\Controllers\FrontController');
echo $framework->execute();