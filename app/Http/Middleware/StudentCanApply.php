<?php

namespace App\Http\Middleware;

use Closure;
use App\Student\Application;
use Illuminate\Support\Facades\Auth;

class StudentCanApply
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->isStudent()) {
            if (!$user->can('create', Application::class)) {
                return redirect('start');
            }
        }
        return $next($request);
    }
}
