<?php

use App\Classes\Database;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\LastSeenMiddleware;
use App\Middleware\RegenerateMiddleware;
use App\Middleware\SessionMiddleware;
use App\Repositories\CityRepository;
use App\Repositories\CourseRepository;
use App\Repositories\PlayerRepository;
use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\ArrayAdapter;
use Dotenv\Repository\RepositoryBuilder;
use League\CommonMark\CommonMarkConverter;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [

    'db' => fn(ContainerInterface $ci) => $ci->get(Database::class),
    'env' => function () {
        return Dotenv::create(RepositoryBuilder::createWithNoAdapters()
            ->addWriter(ArrayAdapter::class)
            ->immutable()
            ->make(), dirname(__DIR__)
        )->load();
    },

    Database::class => function (ContainerInterface $container) {
        $env = $container->get('env');
        return new Database($env['DB_DSN'], $env['DB_USER'], $env['DB_PASSWORD']);
    },

    Environment::class => function (ContainerInterface $container) {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        return new Environment($loader, [
            'cache' => false,
            'debug' => true,
            'charset' => 'utf-8',
        ]);
    },

    CommonMarkConverter::class => function (ContainerInterface $container) {
        return new CommonMarkConverter([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]);
    },

    CityRepository::class => fn (ContainerInterface $ci) => new CityRepository($ci->get('db')),
    CourseRepository::class => fn (ContainerInterface $ci) => new CourseRepository($ci->get('db')),
    PlayerRepository::class => fn (ContainerInterface $ci) => new PlayerRepository($ci->get('db')),

    AuthMiddleware::class => fn() => new AuthMiddleware(),
    GuestMiddleware::class => fn() => new GuestMiddleware(),
    LastSeenMiddleware::class => fn(ContainerInterface $ci) => new LastSeenMiddleware($ci->get(PlayerRepository::class)),
    RegenerateMiddleware::class => fn(ContainerInterface $ci) => new RegenerateMiddleware($ci->get(PlayerRepository::class)),
    SessionMiddleware::class => fn() => new SessionMiddleware(),
];
