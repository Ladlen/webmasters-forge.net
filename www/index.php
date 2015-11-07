<?php

/*
CREATE DATABASE user_list CHARACTER SET cp1251;

CREATE TABLE users
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(30) NOT NULL,
    `age` TINYINT unsigned,
    `city_id` int(11) unsigned,
    PRIMARY KEY (`id`)
) CHARACTER SET cp1251;

CREATE TABLE cities
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(30) NOT NULL,
    PRIMARY KEY (`id`)
) CHARACTER SET cp1251;

ALTER TABLE `users` ADD CONSTRAINT `user_city_id` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

INSERT INTO `cities` SET name='������';
INSERT INTO `cities` SET name='�����������';
INSERT INTO `cities` SET name='��������';

*/

#$className = 'DatabaseOperationsComponent';
#$matches = array();
#$matchesCount = preg_match_all("/.*([A-Z].*)/", $className, $matches);
#print_r($matches);
#exit;

#print_r($_REQUEST);
#exit;

if (version_compare(phpversion(), '5.4.0', '<') == true)
{
    die(_('Please use version of PHP not less than 5.4.'));
}

define('APP_DIR', realpath(__DIR__ . '/../app') . '/');
#die(APP_DIR . 'config/Common.php');
$config = require(APP_DIR . 'config/Common.php');
echo "POS_1<br>\n";
if ($config['debug'])
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
else
{
    error_reporting(0);
}
echo "POS_2<br>\n";
require(APP_DIR . 'helpers/Autoloader.php');

#require_once(APP_DIR . 'controllers/UserController.php');

try
{
    #$user = new UserController();
    (new RouterHelper($config))->run();
}
catch (Exception $e)
{
    if ($config['debug'])
    {
        $msg = sprintf(_('Error occured. Code: %s. Message: %s. File: %s. Line: %s. Trace: %s'),
            $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());

        (new LoggerComponent($config))->log($msg);
    }
    else
    {
        $msg = _('Server error');
    }

    if (empty($_REQUEST['ajax']))
    {
        die($msg);
    }
    else
    {
        die(json_encode(['success' => false, 'message' => $msg]));
    }
}

