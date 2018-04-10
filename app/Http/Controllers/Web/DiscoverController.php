<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscoverController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'student', 'confirmed']);
    }

    public function discover()
    {
        $user = Auth::user();
        if ($user->can('search', User::class)) {
            return view('company.discover');
        } else {
            return view('student.discover');
        }
    }
}
