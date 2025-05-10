<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCities($countryId)
{
    $cities = City::where('country_id', $countryId)->get();
    return response()->json($cities);
}
}
