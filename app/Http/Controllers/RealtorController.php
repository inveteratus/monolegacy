<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class RealtorController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('realtor', [
            'properties' => Property::query()->orderBy('cost')->get(),
        ]);
    }

    public function details(Property $property)
    {
        return view('realtor.details', [
            'property' => $property,
        ]);
    }
}
