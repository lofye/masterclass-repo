<?php

session_start();

require_once '../vendor/autoload.php';
$config = require_once '../config.php';
require_once '../routes.php';
require_once '../diconfig.php';

$framework = $di->newInstance('Masterclass\Controllers\FrontController');
echo $framework->execute();