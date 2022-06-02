<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Gateway\UserGateway;
use App\Manager\UserManager;

$dsn = 'mysql:dbname=nodasoft;host=127.0.0.1';
$user = 'root';
$password = 'root';

$pdo = new PDO($dsn, $user, $password);

$userGateway = new UserGateway($pdo);

$userManager = new UserManager();
