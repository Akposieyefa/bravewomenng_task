<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('subjects', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $create  = Subject::create([
            'name' => $request->name
        ]);
        return redirect()->route('subjects')->with('success', 'Subject added successfully');
    }
}
