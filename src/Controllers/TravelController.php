<?php

namespace App\Controllers;

use App\Classes\View;
use App\Repositories\CityRepository;
use App\Repositories\UserRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;
use Slim\Routing\RouteContext;

class TravelController
{
    #[Inject]
    protected CityRepository $cityRepository;

    #[Inject]
    protected UserRepository $userRepository;

    #[Inject]
    protected View $view;

    public function __invoke(Request $request): Response
    {
        $user = $this->userRepository->getBasic($request->getAttribute("uid"));
        $cities = $this->cityRepository->getAll();

        return $this->view->render('travel.twig', [
            'user' => $user,
            'cities' => $this->sortByDistanceFrom($cities, $cities[$user->city_id]),
        ]);
    }

    public function post(Request $request): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $userId = $request->getAttribute("uid");
        $user = $this->userRepository->getBasic($userId);

        $cities = $this->cityRepository->getAll();
        $cities = $this->sortByDistanceFrom($cities, $cities[$user->city_id]);

        $params = (array)$request->getParsedBody();
        if (!array_key_exists('destination', $params) || !ctype_digit($params['destination'])) {
            return redirect($routeParser->urlFor('travel'));
        }

        $destination = (int)$params['destination'];
        if (!array_key_exists($destination, $cities) || ($destination == $user->city_id)) {
            return redirect($routeParser->urlFor('travel'));
        }

        $this->userRepository->travel($userId, $destination, $cities[$destination]->cost);

        return redirect($routeParser->urlFor('travel'));
    }

    private function sortByDistanceFrom(array $cities, object $from): array
    {
        foreach ($cities as $city) {
            $city->distance = $this->distance($city, $from);
            $city->cost = floor($city->distance / 50) * 50;
        }
        uasort($cities, fn($a, $b) => $a->distance - $b->distance);

        return $cities;
    }

    private function distance(object $city_a, object $city_b): float
    {
        $radius = 6367; // kilometers
        $lat1 = deg2rad($city_a->latitude);
        $lon1 = deg2rad($city_a->longitude);
        $lat2 = deg2rad($city_b->latitude);
        $lon2 = deg2rad($city_b->longitude);
        $dlon = $lon2 - $lon1;
        $dlat = $lat2 - $lat1;
        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = asin(sqrt($a)) * 2;

        return $radius * $c;
    }
}
