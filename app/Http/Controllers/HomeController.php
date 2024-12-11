<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = $this->getUser();

        if (!$user->student_verified_at) {
            return view('not_verified.index');
        }

        if ($user->hasRole('admin')) {
            return view('admin.dashboard.index');
        }

        return view('student.index');
    }
}
