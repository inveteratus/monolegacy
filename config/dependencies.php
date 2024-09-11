<?php

use App\Classes\Database;
use App\Classes\View;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\SeenMiddleware;
use App\Middleware\RegenerateMiddleware;
use App\Middleware\SessionMiddleware;
use App\Repositories\CityRepository;
use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;
use App\Repositories\SeenRepository;
use League\CommonMark\CommonMarkConverter;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [

    'db' => fn(ContainerInterface $ci) => $ci->get(Database::class),

    Database::class => function (ContainerInterface $container) {
        $env = $container->get('settings');
        return new Database($env['DB_DSN'], $env['DB_USER'], $env['DB_PASSWORD']);
    },
    View::class => function (ContainerInterface $ci) {
        return new View(__DIR__ . '/../templates', [
            'cache' => false,
            'debug' => true,
        ]);
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
    UserRepository::class => fn (ContainerInterface $ci) => new UserRepository($ci->get('db')),
    SeenRepository::class => fn (ContainerInterface $ci) => new SeenRepository($ci->get('db')),

    AuthMiddleware::class => fn() => new AuthMiddleware(),
    GuestMiddleware::class => fn() => new GuestMiddleware(),
    SeenMiddleware::class => fn(ContainerInterface $ci) => new SeenMiddleware($ci->get(SeenRepository::class)),
    RegenerateMiddleware::class => fn(ContainerInterface $ci) =>
        new RegenerateMiddleware($ci->get(UserRepository::class)),
    SessionMiddleware::class => fn() => new SessionMiddleware(),
];
