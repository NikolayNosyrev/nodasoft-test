<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\DTO\User;
use App\Gateway\UserGateway;
use App\Manager\UserManager;
use App\DTOFactory\UserDTOFactory;

$dsn = 'mysql:dbname=nodasoft;host=127.0.0.1';
$user = 'root';
$password = 'root';

$pdo = new PDO($dsn, $user, $password);
$userGateway = new UserGateway($pdo);

$userManager = new UserManager($userGateway, new UserDTOFactory());

//$users = $userManager->findNoYoungerThan(2);
//$users = $userManager->findByNames(['lastnames', 'firstname']);
//var_dump($users);

$result = $userManager->saveMultiple([
    new User(null, 'sss', 'xxx', 10, ['test' => 5]),
    new User(null, 'aaa', 'bbb', 40),
    new User(null, 'ccc', 'ddd', 20, ['test' => 15]),
]);

var_dump($result); exit;
