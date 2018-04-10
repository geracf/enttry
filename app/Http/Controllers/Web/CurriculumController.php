<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurriculumController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'student', 'confirmed']);
    }

    public function index()
    {
        return view('student.cv');
    }
}
