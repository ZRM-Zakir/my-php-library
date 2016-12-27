<?php

session_start();

$GLOBALS['config'] = [
    'app' => [
        'app-name' => 'Giga',
    ],
    'mysql' => [
        'host' => '127.0.0.1',
        'db'   => 'client1',
        'username' => 'root',
        'password' => '',
    ],
    'session' => [
        'user_session' => 'JK120',
    ]
];

require_once __DIR__ . '/Configs/Config.php';

spl_autoload_register(function($class)
{
    /**
     *  Provide Your App Name In 'app-name'
     */

    $app = [
        'app-name' => \Giga\Configs\Config::get('app.app-name'),
    ];
    /**
     * |
     * |
     * | This is where autoload is performed
     * |
     * |
     */
    $array = explode("\\",  $class . '.php');

    $folder_l = '';
    $app = $app['app-name'] ;

    foreach ($array as $id => $item) {
        if ($item != $app) {
            $folder_l .= "\\" . $item;
        }
    }
    require_once __DIR__ . $folder_l;
});