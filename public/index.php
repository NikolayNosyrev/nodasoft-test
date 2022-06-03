<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\DTO\UserDTO;
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
    new UserDTO(null, 'sss', 'xxx', 10, ['test' => 5]),
    new UserDTO(null, 'aaa', 'bbb', 40),
    new UserDTO(null, 'ccc', 'ddd', 20, ['test' => 15]),
]);

var_dump($result); exit;
