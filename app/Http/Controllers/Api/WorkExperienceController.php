<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Image;
use App\User;
use App\Picture;
use App\Student\Document;
use App\Student\WorkExperience;

class WorkExperienceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        $experience = collect();

        foreach ($user->workExperience as $work) {
            $experience->push($work->prepareJson());
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
            'organization_name' => 'required|string|max:255',
            'organization_website' => 'nullable|url',
            'title' => 'required|string|max:255',
            // 'technologies_used' => 'required|string',
            'responsibilities' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'current' => 'required|boolean',
            'picture' => 'nullable|image|max:2048',
            'document' => 'nullable|file|mimes:pdf'
        ]);

        $user = Auth::user();

        if ($user->can('create', WorkExperience::class)) {
            $work = new WorkExperience;

            $work->organization_name = $request->organization_name;
            $work->organization_website = $request->organization_website;
            $work->title = $request->title;
            $work->technologies_used = '';
            $work->responsibilities = $request->responsibilities;
            $work->start_date = $request->start_date; // d-m-Y
            $work->end_date = $request->end_date;
            $work->current = $request->current;

            $user->workExperience()->save($work);

            if ($request->picture) {
                $this->addPicture($user, $work, $request->picture);
            }
            if ($request->document) {
                $this->addDocument($user, $work, $request->document);
            }

            $work->thumbnail = $work->thumbnail();
            $work->file_url = $work->file_url();
            return $work;
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
        $work = WorkExperience::findOrFail($id);

        if ($user->can('view', $work)) {
            $work->thumbnail = $work->thumbnail();
            $work->file_url = $work->file_url();
            return $work;
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
        $user = Auth::user();
        $work = WorkExperience::findOrFail($id);

        if ($user->can('update', $work)) {
            $this->validate($request, [
                'organization_name' => 'required|string|max:255',
                'organization_website' => 'nullable|url',
                'title' => 'required|string|max:255',
                'technologies_used' => 'required|string',
                'responsibilities' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'current' => 'required|boolean',
                'picture' => 'nullable|image|max:2048',
                'document' => 'nullable|file|mimes:pdf'
            ]);

            $work->organization_name = $request->organization_name;
            $work->organization_website = $request->organization_website;
            $work->title = $request->title;
            $work->technologies_used = $request->technologies_used;
            $work->responsibilities = $request->responsibilities;
            $work->start_date = $request->start_date; // d-m-Y
            $work->end_date = $request->end_date;
            $work->current = $request->current;

            $work->save();

            if ($request->picture) {
                $this->addPicture($user, $work, $request->picture);
            }
            if ($request->document) {
                $this->addDocument($user, $work, $request->document);
            }

            return $work;
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
        $work = WorkExperience::findOrFail($id);

        if ($user->can('delete', $work)) {
            $work->delete();
            $response = ['id' => $work->id, 'name' => $work->title, 'status' => 'deleted'];

            return $response;
        }

        return response('Not authorized', 403);
    }

    public function addPicture(User $user, WorkExperience $work, $picture)
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

    public function addDocument(User $user, WorkExperience $work, $document)
    {
        if ($work->document) {
            $work->document->delete();
        }

        $doc = new Document;

        $doc->path = $document->store("user/$user->id/experience");
        $doc->type = 'Work Experience';

        $work->document()->save($doc);
    }
}
