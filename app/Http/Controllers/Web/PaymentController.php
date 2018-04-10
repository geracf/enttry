<?php

namespace App\Http\Controllers\Web;

use App\Organization;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\OrganizationCreated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $this->validate($request, [
            'plan' => 'required|string|in:basic,advanced,premium',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'size' => 'required|string',
            'address' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'website' => 'required|url',
            'desc' => 'nullable|string',
            'stripeToken' => 'required|string',
            'stripeTokenType' => 'required|string',
            'stripeEmail' => 'nullable|email',
        ]);

        if ($request->plan == 'basic') {
            $plan = [
                'remaining_offers' => 1,
                'remaining_discover' => 0,
                'remaining_days' => 45
            ];
        } elseif ($request->plan == 'advanced') {
            $plan = [
                'remaining_offers' => 3,
                'remaining_discover' => 30,
                'remaining_days' => 45,
            ];
        } else {
            return back();
        }
        // dd($request->all(), $plan);

        $user = new User;

        $user->name = $request->contact_name;
        $user->email = $request->email;
        $user->role_id = 1;
        $user->password = bcrypt($request->password);
        $user->active = true;

        $organization = new Organization;
        $organization->name = $request->name;
        $organization->size = $request->size;
        $organization->desc = $request->desc;
        $organization->email = $request->email;
        $organization->address = $request->address;
        $organization->website = $request->website;
        $organization->remaining_days = $plan['remaining_days'];
        $organization->remaining_offers = $plan['remaining_offers'];
        $organization->remaining_discover = $plan['remaining_discover'];

        $organization->save();

        $organization->members()->save($user);
        $organization->newSubscription($request->plan, $request->plan)->create($request->stripeToken, [
            'email' => $request->stripeEmail,
        ]);

        $deadline = Carbon::now()->addDays(45)->format('Y-m-d H:i:s');
        $organization->subscription->ends_at = $deadline;
        $organization->subscription->save();

        Mail::to($user)->queue(new OrganizationCreated($user, $organization, $plan));

        return redirect('login');
    }
}
