<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Student\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|string|in:Nuevo,Pendiente,Revisado,Contratado'
        ]);

        $user = Auth::user();
        $application = Application::find($id);

        if ($user->can('update', $application)) {
            $application->status = $request->status;
            $application->save();

            return back()->with('success', 'Estado de la aplicación editado');
        }
        return back()->with('error', 'No puedes acceder a esta función');
    }
}
