<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmAccount;
use App\Picture;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        return redirect("api/user/$user->id");
    }

    public function show($user_id)
    {
        $user = Auth::user();
        $subject = User::findOrFail($user_id);

        if ($user->can('view', $subject)) {
            $response = [
                'dob' => $subject->dob,
                'pic_url' => $subject->avatar(),
                'name' => $subject->name,
                'age' => [
                    'title' => 'Age',
                    'body' => $subject->age
                ],
                'university' => $subject->university ?: null,
                'major' => $subject->major ?: null,
                'education' => [
                    'title' => $subject->university ?: '',
                    'body' => $subject->major ?: ''
                ],
                'student_type' => $subject->studentType(),
                'foi' => $subject->foi,
                'subtitle' => $subject->subtitle,
                'sections' => $subject->sections(),
                'socials' => $subject->socialNetworks(),
                'sex' => [
                    'value' => $subject->sex ? true : false,
                    'text' => $subject->sex ? 'Hombre' : 'Mujer'
                ],
                'state' => $subject->state ?: '',
                'city' => $subject->city ?: '',
                'cellphone' => $subject->cellphone ?: '',
                'availability' => $subject->availability ?: '',
                'graduated_at' => $subject->graduated_at ? $subject->graduated_at->format('Y-m-d') : '',
            ];

            return $response;
        }

        return response('Not authorized', 403);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:255|confirmed',
            // 'picture' => 'nullable|picture|max:2048'
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->activation_id = uniqid();

        $user->save();

        Mail::to($user)->send(new ConfirmAccount($user));

        return $user;
    }

    public function update(Request $request, $user_id)
    {
        $user = Auth::user();
        $subject = User::findOrFail($user_id);

        if ($user->can('update', $subject)) {
            $this->validate($request, [
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email',
                'current_password' => 'required_with:password|string|min:6|max:255',
                'password' => 'required_with:current_password|string|min:6|max:255|confirmed',
                'picture' => 'nullable|image|max:2048',
                'sex' => 'nullable|boolean',
                'location' => 'nullable|string|max:600',
                'type' => 'nullable|in:freelance,intern,full_time',
                'major' => 'nullable|string|max:255',
                'age' => 'nullable|string',
                // 'graduated' => 'nullable|boolean',
            ]);

            if ($request->name) {
                $subject->name = $request->name;
            }
            if ($request->email) {
                $subject->email = $request->email;
            }

            if ($request->password
                && Hash::check($request->current_password, $subject->password)) {
                $subject->password = bcrypt($request->password);
            } elseif ($request->password
                && !Hash::check($request->current_password, $subject->password)) {
                return response('Not authorized', 403);
            }

            // $dob = new Carbon($request->age);

            $user->sex = $request->sex;
            $user->location = $request->location;
            $user->type = $request->type;
            $user->major = $request->major;
            $user->age = $request->age;
            // $user->graduated = $request->graduated;
            $user->student_type = $request->student_type;

            $subject->save();

            if ($request->picture) {
                if ($subject->picture) {
                    $subject->picture->delete();
                }

                // make intervention instance
                $avatar = Image::make($request->picture);

                // resize the avatar img & save
                $avatar->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $avatar->save("./tmp/e-avatar.jpg");

                // get avatar file raw content
                $raw = file_get_contents('./tmp/e-avatar.jpg');

                // create upload url
                $url = "user/$user->id/avatar/".md5($raw).".jpg";

                // actually upload avatar image
                Storage::disk('s3')->getDriver()->put($url, $raw, [ 'visibility' => 'public', 'CacheControl' => 'max_age=2592000']);

                // add to db
                $picture = new Picture;
                $picture->path = $url;
                $picture->desc = $user->name;

                $user->picture()->save($picture);
            }

            $subject->avatar = $subject->avatar();
            return $subject;
        }

        return response('Not authorized', 403);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'sex' => 'nullable|boolean', // m = 1, f = 0
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|in:freelance,full_time,intern',
            'university' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'age_min' => 'nullable|integer|min:16',
            'age_max' => 'nullable|integer|max:99',
            'foi' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255'
            // 'graduated' => 'nullable|boolean'
        ]);

        $user = Auth::user();

        if ($user->can('search', User::class)) {

            $query = "users.role_id = 3 AND ";

            if ($request->sex) {
                $sex = $request->sex ? 'true' : 'false';
                $query .= " users.sex = $sex AND ";
            }

            if ($request->age_min) {
                $query .= " users.age >= $request->age_min AND ";
            }

            if ($request->age_max) {
                $query .= " users.age <= $request->age_max AND ";
            }

            $query .= " unaccent(users.university) ILIKE unaccent('%$request->university%') AND ";
            $query .= " unaccent(users.major) ILIKE unaccent('%$request->major%') AND ";
            $query .= " unaccent(users.foi) ILIKE unaccent('%$request->foi%') AND ";
            $query .= " unaccent(users.availability) ILIKE unaccent('%$request->foi%') AND ";

            $normal = " unaccent(users.state) ILIKE unaccent('%$request->location%')";
            $or = " unaccent(users.city) ILIKE unaccent('%$request->location%')";

            $raw = User::whereRaw($query.$normal)
                ->orWhereRaw($query.$or)->paginate(5);

            foreach ($raw as $student) {
                $results['data'][] = $student->searchResultView();
            }

            $raw = $raw->toArray();

            $results['last_page'] = $raw['last_page'];
            $results['current_page'] = $raw['current_page'];

            // return $raw;
            return $results;
        }

        return response('Not authorized', 403);
    }

    public function setStudentDetails(Request $request)
    {
        $this->validate($request, [
            'name' => 'nullable|string|max:100',
            'desc' => 'nullable|string|max:50',
            'age' => 'nullable|date_format:Y-m-d',
            'university' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'foi' => 'nullable|string|max:100',
            'availability' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'cellphone' => 'nullable|string|max:13',
            'graduated_at' => 'nullable|date_format:Y-m-d',
        ]);

        $user = Auth::user();

        if ($request->age) {
            $user->dob = $request->age;
            $age = Carbon::createFromFormat('Y-m-d', $request->age)->diffInYears();
            $user->age = $age;
        }

        $user->name = $request->name;
        $user->subtitle = $request->desc;
        $user->foi = $request->foi;
        $user->university = $request->university;
        $user->major = $request->major;
        $user->availability = $request->availability;
        $user->sex = $request->sex;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->cellphone = $request->cellphone;
        $user->graduated_at = $request->graduated_at;

        $user->save();

        return $request->all();
    }

    public function getSocialMedia()
    {
        $user = Auth::user();
        return $user->socialNetworks();
    }

    public function setSocialMedia(Request $request)
    {
        $this->validate($request, [
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'spotify' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        $user = Auth::user();

        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->linkedin = $request->linkedin;
        $user->spotify = $request->spotify;
        $user->instagram = $request->instagram;

        $user->save();

        return $user->socialNetworks();
    }
}
