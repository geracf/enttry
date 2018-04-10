<?php

namespace App\Http\Controllers\Api;

use App\Student\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $offers = [
            'data' => $user->getFavoriteOffers(),
            'params' => [
                'can_add' => $user->can('create', Offer::class)
            ]
        ];

        return $offers;
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

        if ($user->can('create', Favorite::class)) {
            $this->validate($request, [
                'offer_id' => 'required|integer|exists:offers,id',
            ]);

            $favorite = new Favorite;
            $favorite->offer_id = $request->offer_id;
            $favorite->notes = "$user->name likes this offer";

            $user->favorites()->save($favorite);

            return ['success' => 'Favorite offer added'];
        }
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
        $favorite = Favorite::findOrFail($id);

        if ($user->can('delete', $favorite)) {
            $favorite->delete();
            return ['success' => 'Favorite deleted'];
        }
    }
}
