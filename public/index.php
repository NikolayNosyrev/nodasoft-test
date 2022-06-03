<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\DTO\User;
use App\Gateway\UserGateway;
use App\Manager\UserManager;
use App\DTOFactory\UserFactory;
use App\PDOProxy;

$dsn = 'mysql:dbname=nodasoft;host=127.0.0.1';
$user = 'root';
$password = 'root';

$pdoProxy = new PDOProxy($dsn, $user, $password);
$userGateway = new UserGateway($pdoProxy);

$userManager = new UserManager($userGateway, new UserFactory());

//$users = $userManager->findNoYoungerThan(15);
//var_dump($users);
//exit;

$names = ['xxx']; // = $_GET['names']
$users = $userManager->findByNames($names);
var_dump($users);
exit;

$users = $userManager->saveMultiple([
    new User(null, 'sss', 'xxx', 10, 'address1', ['test' => 5]),
    new User(null, 'aaa', 'bbb', 40, 'address2'),
    new User(null, 'ccc', 'ddd', 20, 'address3', ['test' => 15]),
]);
var_dump($users);
