<?php

namespace App\Controllers;

use App\Repositories\CityRepository;
use App\Repositories\PlayerRepository;
use DI\Attribute\Inject;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TravelAgentController extends Controller
{
    #[Inject]
    private CityRepository $cityRepository;

    #[Inject]
    private PlayerRepository $playerRepository;

    public function get(Request $request): Response
    {
        $uid = $request->getAttribute("uid");
        $user = $this->playerRepository->getBasic($uid);
        $cities = $this->cityRepository->getAll();

        return $this->view('travel.twig', [
            'user' => $user,
            'cities' => $this->sortByDistanceFrom($cities, $cities[$user->city_id]),
        ]);
    }

    public function post(Request $request): Response
    {
        $uid = $request->getAttribute("uid");
        $user = $this->playerRepository->getBasic($uid);
        $cities = $this->cityRepository->getAll();
        $cities = $this->sortByDistanceFrom($cities, $cities[$user->city_id]);

        $params = (array)$request->getParsedBody();
        if (!array_key_exists('destination', $params) || !ctype_digit($params['destination'])) {
            return $this->redirect('/travel');
        }

        $destination = (int) $params['destination'];
        if (!array_key_exists($destination, $cities) || ($destination == $user->city_id)) {
            return $this->redirect('/travel');
        }

        $this->playerRepository->travel($uid, $destination, $cities[$destination]->cost);

        return $this->redirect('/travel');
    }

    private function sortByDistanceFrom(array $cities, object $from): array
    {
        foreach ($cities as $city) {
            $city->distance = $this->distance($city, $from);
            $city->cost = floor($city->distance / 50) * 50;
        }
        uasort($cities, fn ($a, $b) => $a->distance - $b->distance);

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