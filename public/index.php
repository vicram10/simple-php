<?php

require __DIR__ . '/../vendor/autoload.php';

use Src\Core\AppFactory;

$app = AppFactory::allocIntanceFor();
$app->run();