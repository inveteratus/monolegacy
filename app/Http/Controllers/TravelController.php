<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelRequest;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class TravelController extends Controller
{
    public function __invoke(Request $request): View
    {
        $cities = City::query()->get();

        return view('travel', [
            'cities' => $this->sortByDistanceFrom($cities, $request->user()->city)
        ]);
    }

    public function details(Request $request, City $city): View
    {
        $cities = $this->sortByDistanceFrom(City::query()->get(), $request->user()->city);

        return view('travel-details', [
            'city' => $cities->filter(fn ($item) => $city->id == $item->id)->first(),
        ]);
    }
    public function travel(Request $request, City $city): RedirectResponse
    {
        $cities = $this->sortByDistanceFrom(City::query()->get(), $request->user()->city);
        $city = $cities->filter(fn ($item) => $city->id == $item->id)->first();

        if ($request->user()->cash >= $city->cost) {
            $request->user()->update([
                'cash' => $request->user()->cash - $city->cost,
                'city_id' => $city->id,
            ]);

            return to_route('explore');
        }

        return to_route('travel.details', $city);
    }

    private function sortByDistanceFrom(Collection $cities, City $from): Collection
    {
        foreach ($cities as $city) {
            $city->distance = $this->distance($city, $from);
            $city->cost = floor($city->distance / 250) * 250;
        }

        return $cities->sort(fn (City $a, City $b) => $a->distance - $b->distance);
    }

    private function distance(City $city_a, City $city_b): float
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
