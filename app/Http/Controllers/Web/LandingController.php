<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function students()
    {
        return view('landing.student');
    }

    public function companies()
    {
        return view('landing.companies');
    }

    public function plans($plan)
    {
        if ($plan == 'basic') {
            $plan = 'basic';
            $amount = 44900;
            $name = 'Básico';
            $desc = '1 Proceso por 45 días';
            $img = 'https://stripe.com/img/documentation/checkout/marketplace.png';
        } elseif ($plan == 'advanced') {
            $plan = 'advanced';
            $amount = 99900;
            $name = 'Avanzado';
            $desc = '3 Procesos + 30 Discoveries por 45 días';
            $img = 'https://stripe.com/img/documentation/checkout/marketplace.png';
        } else {
            return back();
        }

        return view('company.payment', [
            'plan' => $plan,
            'amount' => $amount,
            'name' => $name,
            'desc' => $desc,
            'img' => $img,
        ]);
    }
}
