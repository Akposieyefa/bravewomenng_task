<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;

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
        $students = Student::latest()->paginate(5);
        $all = Student::count();
        $active = Student::where('is_active', '=', true)->count();
        $inactive = Student::where('is_active', '=', false)->count();
        $subjects = Subject::count();
        return view('home', compact('students', 'inactive', 'active', 'all', 'subjects' ));
    }
}
