<?php
use Services\Routing\Router;

require_once '../vendor/autoload.php';

require_once '../Services/Routing/Router.php';

$router = new Router();

$router->addRoute('homePage','HomePageController');
$router->addRoute('login','UserController');
$router->addRoute('coin','CoinController');
$router->addRoute('logout','Logout');
$router->addRoute('user-update', 'User-update');
$router->addRoute('user-index', 'User-index');
$router->addRoute('add-user', 'Add-user');
$router->addRoute('404', '404');


$router->launch();

