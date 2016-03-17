<?php

$config['routes'] = array(
        '/' => ['class' => 'Masterclass\Controllers\Index:index', 'type' => 'GET'],

        '/story' => ['class' => 'Masterclass\Controllers\Story:index', 'type' => 'GET'],
        '/story/create' => ['class' => 'Masterclass\Controllers\Story:create', 'type' => 'GET'],
        '/story/create/save' => ['class' => 'Masterclass\Controllers\Story:create', 'type' => 'POST'],

        '/comment/create' => ['class' => 'Masterclass\Controllers\Comment:create', 'type' => 'POST'],

        '/user/create' => ['class' => 'Masterclass\Controllers\User:create', 'type' => 'GET'],
        '/user/account' => ['class' => 'Masterclass\Controllers\User:account', 'type' => 'GET'],
        '/user/account/create' => ['class' => 'Masterclass\Controllers\User:create', 'type' => 'POST'],
        '/user/account/save' => ['class' => 'Masterclass\Controllers\User:account', 'type' => 'POST'],

        '/user/login/check' => ['class' => 'Masterclass\Controllers\User:login', 'type' => 'POST'],
        '/user/login' => ['class' => 'Masterclass\Controllers\User:login', 'type' => 'GET'],
        '/user/logout' => ['class' => 'Masterclass\Controllers\User:logout', 'type' => 'GET'],
        );
