<?php

namespace App\Http\Controllers;
use App\Department;
use App\Classe;
use App\User;
use App\Subject;
use App\Student;
use App\Teacher;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if(auth::user()->position=='admin'){
            $stat['subject'] = count(Subject::all());
            $stat['classe'] = count(Classe::all());
            $stat['department'] = count(Department::all());
            $stat['student'] = count(Student::all());
            $stat['teacher'] = count(Teacher::all());
            $stat['admin'] = count(User::where('position','=','admin')->get());

            return view('admin.dashboard',compact('stat'));
        }
        elseif(auth::user()->position=='teacher'){

            $classatt =auth::user()->teachers()
            ->join ('subjects','teacher_id','=','teachers.id')
            ->join('lessons', 'subject_id', '=', 'subjects.id')
            ->join('classes', 'classes.id', '=', 'lessons.classe_id')->distinct('classes.classe_name')->get();
            $student_nbr=0;
            foreach($classatt as $class){
                $classroom =Student::where('classe_id','=',$class->id)
                ->join('users','users.id','=','students.user_id')
                ->get();
                foreach($classroom as $students){
                    $student_nbr++;
                }
            }
            $stat['classe'] = count($classatt);
            $stat['student'] = $student_nbr;
            return view('teacher_attendance.dashboard',compact('stat'));
        }
        elseif(auth::user()->position=='student'){
            $student_schedule =auth::user()->students()
            ->join ('classes','classes.id','=','students.classe_id')
            ->join('lessons', 'lessons.classe_id', '=', 'classes.id')
            ->join ('subjects','lessons.subject_id','=','subjects.id')->get();
            
            $studentatt =auth::user()->students()->join ('student_attendances','student_id','=','students.id')->join('lessons', 'lessons.id', '=', 'student_attendances.lesson_id')->join('subjects', 'subjects.id', '=', 'lessons.subject_id')->get();

            $stat['sub_nbr']=count($student_schedule);
            $stat['att_nbr']=count($studentatt);
            return view('student_attendance.dashboard',compact('stat'));
        }
    }
}
