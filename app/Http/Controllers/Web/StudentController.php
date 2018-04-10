<?php

namespace App\Http\Controllers\Web;

use App\ChatRoom;
use App\Http\Controllers\Controller;
use App\Mail\IWantYou;
use App\Message;
use App\Offer;
use App\Services\SocialFacebookAccountService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Date\Date;
use Laravel\Socialite\Facades\Socialite;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['socialLogin', 'callback']]);
    }

    public function show($student_id)
    {
        Date::setLocale('es');
        $user = Auth::user();
        $student = User::with('skills')->findOrFail($student_id);

        if ($user->can('view', $student)) {
            return view('student.show', [
                'student' => $student,
            ]);
        }
        return back()->with('error', 'No puedes ver a este usuario.');
    }

    public function discover(Request $request, $student_id)
    {
        $this->validate($request, [
            'offer_id' => 'required|integer|exists:offers,id',
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        $student = User::findOrFail($student_id);
        $offer = Offer::findOrFail($request->offer_id);

        if ($user->can('contact', $student)) {
            Mail::to($student)->queue(new IWantYou($student, $offer, $request->message));

            $organization = $user->organization;
            $organization->remaining_discover -= 1;

            $organization->save();

            return redirect("student/$student->id")
                    ->with('success', 'Mensaje directo enviado por correo!');
        }

        return back()->with('error', 'No puedes contactar a este usuario.');
    }

    public function socialLogin()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        Auth::login($user);

        return redirect("start");
    }
}
