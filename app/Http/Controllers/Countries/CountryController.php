<?php

namespace App\Http\Controllers\Countries;

use App\Models\Country;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index()
    {
    	return CountryResource::collection(Country::get());
    }
}
