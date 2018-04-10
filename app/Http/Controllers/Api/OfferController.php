<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Traits\UsesPictures;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Offer;

class OfferController extends Controller
{
    use UsesPictures;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     * It also filters the offers
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->can('search', Offer::class)) {
            $this->validate($request, [
                'keywords' => 'nullable|string',
                'location' => 'nullable|string',
                'category' => 'nullable|string',
                'type' => 'nullable|string',
                'page' => 'nullable|integer',
            ]);

            $query = [];
            $query[] = ['name', 'ilike', '%'.$request->keywords.'%'];
            // $query[] = ['location', 'ilike', '%'.$request->location.'%'];
            // $query[] = ['category', 'ilike', '%'.$request->category.'%'];
            // $query[] = ['type', 'ilike', '%'.$request->type.'%'];

            $results = Offer::where($query)->orderBy('created_at', 'desc')->paginate(6);

            foreach ($results as $offer) {
                $offer->prepareJson($user);
                $offer->has_questions = $offer->hasQuestions();
                unset($offer->favorites);
            }

            $results->next_url = $request->fullUrlWithQuery($request->toArray());

            return $results;
        }

        return response('Not authorized', 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        dd($user->organization, $request->all());

        if ($user->can('create', Offer::class)) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'desc' => 'nullable|string',
                'salary' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'show_location' => 'required|boolean',
                'lat' => 'nullable|numeric',
                'lng' => 'nullable|numeric',
                'remote' => 'required|boolean',
                'pictures' => 'nullable|array|min:1',
                'pictures.*' => 'required|image|max:2048',
            ]);

            $offer = new Offer;
            $offer->name = $request->name;
            $offer->organization_id = $user->organization->id;
            $offer->category = $request->category;
            $offer->type = $request->type;
            $offer->desc = $request->desc;
            $offer->salary = $request->salary;
            $offer->location = $request->location;
            $offer->show_location = $request->show_location;
            $offer->lat = $request->lat;
            $offer->lng = $request->lng;
            $offer->remote = $request->remote;

            $offer->save();

            if ($request->pictures) {
                $this->addMany($offer, $request->pictures, "offers/$offer->id");
            }

            return $offer;
        }

        return response('Not authorized', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($id);

        if ($user->can('view', $offer)) {
            $offer->organization;
            $offer->has_questions = $offer->hasQuestions();
            $offer->requirements;
            $offer->questions;
            $offer->prepareJson($user);
            return $offer;
        }

        return response('Not authorized', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'remote' => 'required|boolean',
            'pictures' => 'nullable|array|min:1',
            'pictures.*' => 'required|image|max:1024',
        ]);

        $user = Auth::user();
        $offer = Offer::findOrFail($id);

        if ($user->can('update', $offer)) {
            $offer->name = $request->name;
            $offer->organization_id = $user->organization->id;
            $offer->category = $request->category;
            $offer->type = $request->type;
            $offer->desc = $request->desc;
            $offer->salary = $request->salary;
            $offer->location = $request->location;
            $offer->show_location = $request->show_location;
            $offer->lat = $request->lat;
            $offer->lng = $request->lng;
            $offer->remote = $request->remote;

            $offer->save();

            if ($request->pictures) {
                $this->addMany($offer, $request->pictures, "offers/$offer->id");
            }

            return $offer;
        }

        return response('Not authorized', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($id);

        if ($user->can('delete', $offer)) {
            $offer->delete();
            $response = ['id' => $offer->id, 'name' => $offer->title, 'status' => 'deleted'];

            return $response;
        }

        return response('Not authorized', 403);
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $query = '';

        if ($request->remote != null) {
            $remote = $request->remote ? 'true' : 'false';
            $query .= "remote = $remote AND ";
        }

        $query .= " unaccent(offers.location) ILIKE unaccent('%$request->location%') AND";
        $query .= " unaccent(offers.looking_for) ILIKE unaccent('%$request->looking%') AND";
        $query .= " unaccent(offers.type) ILIKE unaccent('%$request->category%') AND";

        $normal = " unaccent(offers.desc) ILIKE unaccent('%$request->keywords%') ";
        $or = " unaccent(offers.name) ILIKE unaccent('%$request->keywords%')";

        $raw = Offer::whereRaw($query.$normal)
            ->orWhereRaw($query.$or)->paginate(5);

        // return [
        //     'request' => $request->toArray(),
        //     'raw' => $raw,
        //     'query' => $query,
        // ];

        $results = [];

        foreach ($raw as $offer) {
            $results['data'][] = $offer->searchResultView($user);
        }

        $raw = $raw->toArray();
        $results['last_page'] = $raw['last_page'];
        $results['current_page'] = $raw['current_page'];

        return $results;
    }
}
