<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Image;
use App\User;
use App\Picture;
use App\Student\FeaturedWork;

class FeaturedWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $works = FeaturedWork::with('picture')->where('user_id', Auth::user()->id)->latest()->get();
        $res = [];

        foreach ($works as $work) {
            $work->full();
            $work->thumbnail = $work->thumbnail();
            $res[] = $work;
        }
        return $res;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'feature_name' => 'required|string|max:255',
            'feature_url' => 'nullable|url',
            'desc' => 'required|string',
            'release_date' => 'required|date', // d-m-Y
        ]);

        $user = Auth::user();

        if ($user->can('create', FeaturedWork::class)) {
            $feature = new FeaturedWork;

            $feature->feature_name = $request->feature_name;
            $feature->feature_url = $request->feature_url;
            $feature->technologies_used = '';
            $feature->desc = $request->desc;
            $feature->release_date = $request->release_date;

            $user->featuredWork()->save($feature);

            if ($request->picture) {
                $this->addPicture($user, $feature, $request->picture);
            }

            $feature->thumbnail = $feature->thumbnail();
            return $feature;
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
        $feature = FeaturedWork::findOrFail($id);

        if ($user->can('view', $feature)) {
            $feature->full();
            $feature->thumbnail = $feature->thumbnail();
            return $feature;
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
            'feature_name' => 'required|string|max:255',
            'feature_url' => 'nullable|url',
            'technologies_used' => 'nullable|string',
            'desc' => 'nullable|string',
            'release_date' => 'nullable|date', // d-m-Y
            'picture' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();
        $feature = FeaturedWork::findOrFail($id);

        if ($user->can('update', $feature)) {
            $feature->feature_name = $request->feature_name;
            $feature->feature_url = $request->feature_url;
            $feature->technologies_used = $request->technologies_used;
            $feature->desc = $request->desc;
            $feature->release_date = $request->release_date;

            $feature->save();

            if ($request->picture) {
                $this->addPicture($user, $feature, $request->picture);
            }

            return $feature;
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
        $feature = FeaturedWork::findOrFail($id);

        if ($user->can('delete', $feature)) {
            $feature->delete();
            $response = ['id' => $feature->id, 'name' => $feature->title, 'status' => 'deleted'];

            return $response;
        }

        return response('Not authorized', 403);
    }

    public function addPicture(User $user, FeaturedWork $work, $picture)
    {
        if ($work->picture) {
            $work->picture->delete();
        }

        // make intervention instance
        $thumbnail = Image::make($picture);

        // resize the thumbnail img & save
        $thumbnail->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbnail->save("./tmp/experience-thumb.jpg");

        // get avatar file raw content
        $raw = file_get_contents('./tmp/experience-thumb.jpg');

        // create upload url
        $url = "user/$user->id/experience/".md5($raw).".jpg";

        // actually upload avatar image
        Storage::disk('s3')->getDriver()->put($url, $raw, [ 'visibility' => 'public', 'CacheControl' => 'max_age=2592000']);

        // add to db
        $picture = new Picture;
        $picture->path = $url;
        $picture->desc = $work->title;

        $work->picture()->save($picture);
    }
}
