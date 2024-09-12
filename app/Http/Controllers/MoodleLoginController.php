<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MoodleLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:moodle')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.moodle-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('moodle')->attempt($credentials, $request->filled('remember'))) {
            $userId = Auth::guard('moodle')->id();

            // Cek apakah user ada di tabel mdl_role_assignments
            $roleAssignment = DB::connection('moodle')
                ->table('mdl_role_assignments')
                ->where('userid', $userId)
                ->first();

            if ($roleAssignment) {
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'These credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('moodle')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard('moodle');
    }
}
