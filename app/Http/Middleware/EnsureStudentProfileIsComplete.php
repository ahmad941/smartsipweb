<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureStudentProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'siswa' && !Auth::user()->student) {
            if (!$request->routeIs('student.profile.setup') && !$request->routeIs('student.profile.setup.store') && !$request->routeIs('logout')) {
                return redirect()->route('student.profile.setup');
            }
        }

        return $next($request);
    }
}
