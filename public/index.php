<?php

/**
 * Front controller
 *
 * PHP version 5.4
 */

/**
 * Composer
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');
error_reporting(E_ALL);


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/`token:[\da-f]+`', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/`token:[\da-f]+`', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('settings/emailChange/`token:[\da-f]+`', ['controller' => 'Settings', 'action' => 'emailChange']);
$router->add('`controller`/`action`');

$router->add('expenses/limit/`category:[\wżźćńółęąśŻŹĆŃÓŁĘĄŚ]+`', ['controller' => 'Expenses', 'action' => 'limit']);
$router->add('expenses/categorySum/`category:[\wżźćńółęąśŻŹĆŃÓŁĘĄŚ]+`'.
            '/`date:[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])`',
            ['controller' => 'Expenses', 'action' => 'categorySum']);

$router->dispatch($_SERVER['QUERY_STRING']);
