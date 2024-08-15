<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedirectIfNotMurid
{
    public function handle($request, Closure $next)
    {
        $userId = Auth::guard('moodle')->id();
        $roleAssignment = DB::connection('moodle')
            ->table('role_assignments')
            ->where('userid', $userId)
            ->first();

        if ($roleAssignment) {
            Auth::guard('moodle')->logout(); // Log out the user
            return redirect()->route('moodle.login');
        }

        return $next($request);
    }
}
