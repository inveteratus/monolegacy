<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RealtorController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('realtor', [
            'properties' => Property::query()->orderBy('cost')->get(),
        ]);
    }

    public function details(Request $request, Property $property): View
    {
        return view('realtor-details', [
            'property' => $property,
            'cost' => $property->cost - ($request->user()->property->cost * 0.9),
        ]);
    }

    public function purchase(Request $request, Property $property): RedirectResponse
    {
        $user = $request->user();
        $cost = $property->cost - $user->property->cost * 0.9;

        if (($property->cost > $user->property->cost) && ($user->cash >= $cost)) {
            $user->property_id = $property->id;
            $user->cash = $user->cash - $cost;
            $user->save();
        }

        return to_route('realtor.details', $property);
    }
}
