<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\User;

class PaymentMethod extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {

        // Validate stripe's form
        // $this->validate($request, [
        // 	'first_name' => 'required|string|max:255',
        // 	'last_name' => 'required|string|max:255',
        // 	'number' => 'required|ccn',
        // 	'expiration' => 'required|ccd',
        // 	'cvc' => 'required|cvc',
        // ]);

        $this->validate($request, [
            'stripe_token' => 'required|string|max:255',
            'plan_name' => 'required|string|max:255',
            'plan_id' => 'required|string|max:255'
        ]);

        $user = Auth::user();

        // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // $expiration = explode('/', $request->expiration);

        // This has to be done at the front end, retrieve the token and send to this method as 'stripe_token'
        // $response = \Stripe\Token::create(array(
        // 	"card" => array(
        // 		"number" => $request->number,
        // 		"exp_month" => $expiration[0],
        // 		"exp_year" => $expiration[1],
        // 		"cvc" => $request->cvc,
        // 		"name" => "$request->first_name $request->last_name",
        // 	)
        // ));

        // $response_array = $response->__toArray(true);

        if ($user->can('subscribe', User::class)) {
            $user->newSubscription($request->plan_name, $request->plan_id)->create($request->stripe_token, [
                'email' => $user->email
            ]);

            return ['subscription' => $request->plan_name, 'status' => 'Subscrito'];
        }
        
        return response('Not authorized', 403);
    }

    public function plans()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        return \Stripe\Plan::all();
    }
}
