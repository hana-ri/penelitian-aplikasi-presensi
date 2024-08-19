<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index() {
        return view('admin.class');
    }

    public function create() {
        return view('admin.create');
    }
}
