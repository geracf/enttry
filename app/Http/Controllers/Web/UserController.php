<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmAccount;
use App\Picture;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['register', 'confirm']]);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->role_id = 3;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->activation_id = uniqid();

        try {
            $user->save();
            Mail::to($user)->send(new ConfirmAccount($user));
            return redirect("login")->with('success', 'Revisa tu correo, hemos enviado un email de confirmación!');
        } catch (QueryException $e) {
            return redirect('login')->with('error', 'El correo que quieres registrar ya está en uso');
        }
    }

    public function pictureUpload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|max:2048',
        ]);

        $user = Auth::user();

        if ($user->picture) {
            $user->picture->delete();
        }

        $picture = new Picture;

        $picture->path = $request->file('file')->store("avatars/$user->id");
        $picture->desc = $user->name;
        $user->picture()->save($picture);

        return json_encode(['status' => 'ok']);
    }

    public function confirm($confirm_id)
    {
        $user = User::where('activation_id', $confirm_id)->firstOrFail();

        if ($user->active == false) {
            $user->active = true;
            $user->save();

            Auth::login($user);

            return redirect("start")->with('success', 'Tu cuenta está activada, puedes iniciar sesión');
        }
        return redirect("login")->with('error', 'Esta cuenta ya está activada');
    }
}
