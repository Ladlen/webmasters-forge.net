<?php

// ������� ������ � ����������� DatabaseOperations ��� ��������� �������� � ��.
/*define('DATABASE', 'mySqli');

// ������ ����������.
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', 'temp123');
define('MYSQL_DB', 'user_list');

define('DATABASE_CLASS', DATABASE . 'DatabaseOperations');

define('DOCUMENT_ENCODING', 'cp1251');

// ������������ ����������� ������.
define('DEBUG', true);

// Application log path.
define('APP_LOG', APP_DIR . 'runtime/logs/app.log');
*/

$config = [
    'appDir' => dirname(__DIR__),

    'database' => [
        'type' => 'MySqli',
        'connection' => [
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'temp123',
            'databaseName' => 'users'
        ],
    ],

    // Log file info.
    'log' => [
        // Path to log file.
        'filePath' => dirname(__DIR__) . 'runtime/logs/app.log',
        // Maximal log file size in bytes.
        #'maxZise' => 200   // TODO: let's disable this
    ],

    // Switch the debug mode
    'debug' => true
];

$config['database']['className'] = $config['database']['type'] . 'DatabaseComponent';

return $config;