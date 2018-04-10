<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppliedController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'student', 'confirmed']);
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->isStudent()) {
            return view('student.applied');
        }

        return back();
    }
}
