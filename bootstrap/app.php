<?php

use App\Classes\Database;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\LastSeenMiddleware;
use App\Middleware\RegenerateMiddleware;
use App\Middleware\SessionMiddleware;
use App\Repositories\CityRepository;
use App\Repositories\PlayerRepository;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\ArrayAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Psr\Container\ContainerInterface;
use Respect\Validation\Factory;
use Slim\App;
use Slim\Factory\AppFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('App\\Validation\\Rules')
        ->withExceptionNamespace('App\\Validation\\Exceptions')
);

return new class {
    public function __invoke(): App
    {
        $builder = new ContainerBuilder();

        $builder->useAttributes(true);
        $builder->useAutowiring(true);
        $builder->addDefinitions([
            'env' => function () {
                return Dotenv::create(RepositoryBuilder::createWithNoAdapters()
                    ->addWriter(ArrayAdapter::class)
                    ->immutable()
                    ->make(), dirname(__DIR__)
                )->load();
            },
            Database::class => function (ContainerInterface $containerInterface) {
                $env = $containerInterface->get('env');
                return new Database($env['DB_DSN'], $env['DB_USER'], $env['DB_PASSWORD']);
            },
            FilesystemLoader::class => function () {
                return new FilesystemLoader(__DIR__ . '/../templates');
            },
            Environment::class => function (ContainerInterface $containerInterface) {
                return new Environment($containerInterface->get(FilesystemLoader::class), [
                    'cache' => false,
                    'debug' => true,
                    'charset' => 'utf-8',
                ]);
            },

            /* Repositories */

            CityRepository::class => function (ContainerInterface $container) {
                return new CityRepository($container->get(Database::class));
            },

            PlayerRepository::class => function (ContainerInterface $container) {
                return new PlayerRepository($container->get(Database::class));
            },

            /* Middleware */

            SessionMiddleware::class => function () {
                return new SessionMiddleware();
            },

            GuestMiddleware::class => function () {
                return new GuestMiddleware();
            },

            AuthMiddleware::class => function () {
                return new AuthMiddleware();
            },

            LastSeenMiddleware::class => function (ContainerInterface $ci) {
                return new LastSeenMiddleware($ci->get(PlayerRepository::class));
            },

            RegenerateMiddleware::class => function (ContainerInterface $ci) {
                return new RegenerateMiddleware($ci->get(PlayerRepository::class));
            },
        ]);

        $container = $builder->build();
        AppFactory::setContainer($container);

        $app = AppFactory::create();
        $container->set(App::class, $app);

        return $app;
    }
};
