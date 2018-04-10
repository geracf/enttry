<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Student\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'confirmed']);
    }

    public function index()
    {
        $user = Auth::user();
        return view('student.start');
        // if (!$user->can('create', Application::class)) {
        //     return view('student.start');
        // }
        // return redirect("home");
    }
}
