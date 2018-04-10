<?php

namespace App\Http\Controllers\Web;

use App\ChatRoom;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Student\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOfferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'confirmed']);
    }

    public function index()
    {
        $user = Auth::user();
        $offers = Offer::where('organization_id', $user->organization_id)->get();
        return view('my_offers.index', [
            'offers' => $offers,
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($id);

        if ($user->can('viewDetails', $offer)) {
            return view('my_offers.show', [
                'offer' => $offer,
            ]);
        }

        return back()->with('error', 'No puedes acceder a esta URL');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($id);

        if ($user->can('update', $offer)) {
            return view('my_offers.edit', [
                'offer' => $offer,
            ]);
        }

        return back()->with('error', 'No puedes acceder a esta URL');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'salary' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'show_location' => 'required|boolean',
            'lat' => 'nullable|required_with:lng|numeric',
            'lng' => 'nullable|required_with:lat|numeric',
            'remote' => 'required|boolean',
            'pictures' => 'nullable|array|min:1',
            'pictures.*' => 'required|image|max:2048',
            'looking_for' => 'required|string'
        ]);

        $user = Auth::user();
        $offer = Offer::findOrFail($id);

        if ($user->can('update', $offer)) {

            $offer->name = $request->name;
            $offer->category = $request->category;
            $offer->type = $request->type;
            $offer->desc = $request->desc;
            $offer->salary = '$ ' .$request->salary. ' MXN/Mes';
            $offer->location = $request->location;
            $offer->show_location = $request->show_location;
            $offer->lat = $request->lat;
            $offer->lng = $request->lng;
            $offer->remote = $request->remote;

            $offer->save();

            return back()->with('success', 'Oferta editada!');
        }

        return back()->with('error', 'No puedes acceder a esta URL');
    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($id);

        if ($user->can('delete', $offer)) {
            $offer->delete();
            return back()->with('success', 'Oferta eliminada');
        }

        return back()->with('error', 'No puedes acceder a esta URL');
    }

    public function chat($id)
    {
        $user = Auth::user();
        $application = Application::with('chats')->findOrFail($id);
        $offer = $application->offer;

        if ($user->can('view', $application)) {
            return view('my_offers.chat', [
                'offer' => $offer,
                'application' => $application,
            ]);
        }

        return back()->with('error', 'No puedes acceder a esta URL');
    }
}
