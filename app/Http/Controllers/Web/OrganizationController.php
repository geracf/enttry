<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmCompanyAccount;
use App\Organization;
use App\Picture;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store', 'confirm']]);
    }

    public function pictureUpload(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization;

        if ($user->can('update', $organization)) {
            $this->validate($request, [
                'file' => 'required|file|max:2048'
            ]);

            if ($organization->pictures) {
                $organization->pictures()->delete();
            }

            $picture = new Picture;

            $picture->path = $request->file('file')->store("organization/$organization->id");
            $picture->desc = $organization->name;
            $organization->pictures()->save($picture);

            return json_encode(['status' => 'ok']);
        }

        return back();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:255|confirmed',
            'company_name' => 'required|string|max:255',
            'company_size' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);
        // dd($request->all());

        $organization = new Organization;
        $organization->name = $request->company_name;
        $organization->size = $request->company_size;
        $organization->desc = $request->desc;
        $organization->address = $request->address;
        $organization->website = $request->website;
        $organization->email = $request->email;
        $organization->remaining_offers = 3;
        $organization->remaining_days = 30;
        $organization->save();

        $user = new User;
        $user->role_id = 2;
        $user->name = $request->user_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->organization_id = $organization->id;
        $user->save();

        Auth::login($user);

        Mail::to($user)
            ->queue(new ConfirmCompanyAccount($user));

        return redirect('/home')->with('success', 'Confirma tu cuenta para publicar una vacante');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);
    }

    public function confirm($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->confirmed = true;

        $user = $organization->members->first();
        $user->active = true;
        $user->save();

        return redirect('login')->with('success', 'Cuenta confirmada');
    }
}
