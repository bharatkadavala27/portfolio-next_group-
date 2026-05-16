<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect('/login')->with('message', 'You must be logged in to access this page.');
        }

        // Check if the user is not an admin
        if (Auth::user()->role_as != '1') {  // Assuming 1 means admin, adjust based on your setup
            return redirect('/home')->with('message', 'You do not have admin access.');
        }

        // If user is an admin, allow the request to proceed
        return $next($request);

        // return $next($request);
    }


}
