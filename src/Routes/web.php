<?php

use Src\Controllers\WelcomeController;
use Src\Core\Router;

require __DIR__ . '/../Core/Router.php';

Router::get('/', [WelcomeController::class, 'index']);