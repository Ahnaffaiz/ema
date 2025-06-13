<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentAccessRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply restrictions if the user is logged in
        if (Auth::check()) {
            $user = Auth::user();

            // Check if user has ONLY the student role and no other roles
            $roles = $user->getRoleNames();

            // If user has exactly one role and that role is 'student'
            if (count($roles) === 1 && $roles[0] === 'student') {
                // List of allowed routes for students
                $allowedRoutes = [
                    'exam.login',
                    'exam.take',
                    'exam.completed'
                ];

                // If the current route is not in the allowed routes, redirect to exam login
                if (!in_array($request->route()->getName(), $allowedRoutes)) {
                    return redirect()->route('exam.login');
                }
            }
        }

        return $next($request);
    }
}
