<?php

use App\Core\Router;
use App\Controllers\HomeController;

$router = new Router();

$router->get('home', [new HomeController(), 'index']);
$router->get('user/{id}', [new HomeController(), 'showUser']);

return $router;

