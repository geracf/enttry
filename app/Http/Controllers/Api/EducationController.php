<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Image;
use App\User;
use App\Picture;
use App\Student\Education;

class EducationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        $experience = collect();

        foreach ($user->education as $education) {
            $experience->push($education->prepareJson());
        }

        return $experience->sortBy('from');
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
            'university_id' => 'nullable|integer|exists:universities,id',
            'school_name' => 'required|string|max:255',
            'school_website' => 'nullable|url',
            'degree' => 'required|string|max:255',
            // 'technologies_used' => 'string|max:255',
            'achivements' => 'string|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'nullable|required_if:current,false|date',
            'current' => 'required|boolean',
            'picture' => 'nullable|image|max:2048',
        ]);

        // dd($request->all());

        $user = Auth::user();
        if ($user->can('create', Education::class)) {
            $education = new Education;

            $education->school_name = $request->school_name;
            $education->school_website = $request->school_website;
            $education->degree = $request->degree;
            $education->technologies_used = '';
            $education->achivements = $request->achivements;
            $education->start_date = $request->start_date;
            $education->end_date = $request->end_date;
            $education->current = $request->current;

            $user->education()->save($education);

            if ($request->picture) {
                $this->addPicture($user, $education, $request->picture);
            }

            $education->thumbnail = $education->thumbnail();
            return $education;
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
        $education = Education::findOrFail($id);

        if ($user->can('view', $education)) {
            $education->full();
            $education->thumbnail = $education->thumbnail();
            return $education;
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
            'school_name' => 'required|string|max:255',
            'school_website' => 'required|url',
            'degree' => 'required|string|max:255',
            'technologies_used' => 'string|max:255',
            'achivements' => 'string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'current' => 'required|boolean',
            'picture' => 'nullable|image|max:2048',
        ]);

        // dd($request->all());

        $user = Auth::user();
        $education = Education::findOrFail($id);

        if ($user->can('update', $education)) {
            $education->user_id = $user->id;
            $education->school_name = $request->school_name;
            $education->school_website = $request->school_website;
            $education->degree = $request->degree;
            $education->technologies_used = $request->technologies_used;
            $education->achivements = $request->achivements;
            $education->start_date = $request->start_date;
            $education->end_date = $request->end_date;
            $education->current = $request->current;

            $education->save();

            if ($request->picture) {
                $this->addPicture($user, $education, $request->picture);
            }

            $education->thumbnail = $education->thumbnail();
            return $education;
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
        $education = Education::findOrFail($id);

        if ($user->can('delete', $education)) {
            $education->delete();
            $response = ['id' => $education->id, 'name' => $education->school_name, 'status' => 'deleted'];

            return $response;
        }

        return response('Not authorized', 403);
    }

    public function addPicture(User $user, Education $education, $picture)
    {
        if ($education->picture) {
            $education->picture->delete();
        }

        // make intervention instance
        $thumbnail = Image::make($picture);

        // resize the thumbnail img & save
        $thumbnail->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbnail->save("./tmp/education-thumb.jpg");

        // get avatar file raw content
        $raw = file_get_contents('./tmp/education-thumb.jpg');

        // create upload url
        $url = "user/$user->id/education/".md5($raw).".jpg";

        // actually upload avatar image
        Storage::disk('s3')->getDriver()->put($url, $raw, [ 'visibility' => 'public', 'CacheControl' => 'max_age=2592000']);

        // add to db
        $picture = new Picture;
        $picture->path = $url;
        $picture->desc = $education->title;

        $education->picture()->save($picture);
    }
}
