<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Subject;

class StudentController extends Controller
{
    private $helper;

    public function __construct(Helper $helper)
    {
       $this->helper = $helper;
    }

   public function create()
   {
       $subjects = Subject::all();
       return view('create', compact('subjects'));
   }

   public function store(Request $request)
   {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'phone' => 'required|min:11|max:11',
            'dob' => 'required',
            'address' => 'required',
            'e_phone' => 'required',
            'class' => 'required',
            'subject_id' => 'required|array',
        ]);
        $create  = Student::create([
            'student_id' => $this->helper->getRandomStudent(10),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'address' => $request->address,
            'e_phone' => $request->e_phone,
            'class_name' => $request->class
        ]);
        foreach($request->input('subject_id') as $subject)
        {
            $create->subjects()->attach($subject);
        }
        return redirect()->route('register-student')->with('success', 'Student added successfully');
   }

   public function edit($id)
   {
       $student = Student::find($id);
       return view('edit', compact('student'));
   }

   public function update(Request $request, $id)
   {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:11|max:11',
            'dob' => 'required',
            'address' => 'required',
            'e_phone' => 'required',
            'class' => 'required'
        ]);
        $student = Student::find($id);

        $update = $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'address' => $request->address,
            'e_phone' => $request->e_phone,
            'class_name' => $request->class
        ]);
        return redirect()->back()->with('success', 'Student details updated successfully');
   }

   public function studentSearch(Request $request)
   {
        $all = Student::count();
        $active = Student::where('is_active', '=', true)->count();
        $inactive = Student::where('is_active', '=', false)->count();
        $subjects = Subject::count();
        $searchString = $request->input('studentSearch');
        if($searchString != "") {
            $students = Student::where('student_id', 'LIKE', '%'.$searchString.'%')
                        ->orWhere('name', 'LIKE', '%'.$searchString.'%')
                        ->orWhere('dob', 'LIKE', '%'.$searchString.'%')
                        ->orWhere('address', 'LIKE', '%'.$searchString.'%')
                        ->orWhere('class_name', 'LIKE', '%'.$searchString.'%')
                        ->orWhere('email', 'LIKE', '%'.$searchString.'%')
                        ->orWhere('phone', 'LIKE', '%'.$searchString.'%')
                        ->orWhere('e_phone', 'LIKE', '%'.$searchString.'%')
                        ->orWhere('id', 'LIKE', '%'.$searchString.'%')
                        ->paginate(5)
                        ->setPath('');
            $students->appends(array(
                'studentSearch' => $request->input('studentSearch'),
            ));
            if (count($students) > 0) {
                return  view('home', compact('students', 'inactive', 'active', 'all', 'subjects' ));
            }
            return  view('home', compact('students', 'inactive', 'active', 'all' ))->with('message',"No record found");
        }
    }

    public function suspend($id)
    {
        $student = Student::find($id);
        $suspend = $student->update([
            'is_active' => false
        ]);
        return redirect()->route('home')->with('success', 'You have suspended this student');
    }

    public function activate($id)
    {
        $student = Student::find($id);
        $suspend = $student->update([
            'is_active' => true
        ]);
        return redirect()->route('home')->with('success', 'You have activated this student');
    }


   public function destroy($id)
   {
       $student = Student::find($id);
       $delete = $student->delete();
       return redirect()->route('home')->with('success', 'Student deleted successfully');
   }
}
