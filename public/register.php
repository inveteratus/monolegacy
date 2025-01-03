<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use eftec\bladeone\BladeOne;
use Monolegacy\Classes\Database;
use Monolegacy\Classes\ResponseEmitter;
use Monolegacy\Controllers\RegisterController;
use Monolegacy\Repositories\UserRepository;
use Psr\Container\ContainerInterface;
use Respect\Validation\Factory;
use Slim\Psr7\Factory\ServerRequestFactory;

session_start(['name' => 'MCCSID']);
if (array_key_exists('userid', $_SESSION) && ($_SESSION['userid'] > 0)) {
    header('Location: /');
    exit;
}

Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('Monolegacy\\Validation\\Rules')
        ->withExceptionNamespace('Monolegacy\\Validation\\Exceptions')
);

$container = (new ContainerBuilder())
    ->useAutowiring(true)
    ->useAttributes(true)
    ->addDefinitions([
        'config' => fn(ContainerInterface $ci) => Dotenv::createArrayBacked(dirname(__DIR__))->load(),
        BladeOne::class => fn() => new BladeOne(dirname(__DIR__) . '/views', dirname(__DIR__) . '/cache', BladeOne::MODE_DEBUG),
        Database::class => fn(ContainerInterface $ci) => new Database($ci->get('config')['DB_DSN'], $ci->get('config')['DB_USER'], $ci->get('config')['DB_PASSWORD']),
        UserRepository::class => fn(ContainerInterface $ci) => new UserRepository($ci->get(Database::class)),
    ])->build();

$request = ServerRequestFactory::createFromGlobals();
$response = $container->call(RegisterController::class, [$request]);

(new ResponseEmitter())->emit($response);
