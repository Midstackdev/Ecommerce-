<?php

namespace App\Http\Controllers\PaymentMethods;

use App\Http\Resources\PaymentMethodResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth:api']);
	}

    public function index(Request $request)
    {
    	return PaymentMethodResource::collection(
    		$request->user()->paymentMethods
    	);
    }
}
