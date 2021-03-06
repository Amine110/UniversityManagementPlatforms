<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Notif;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::middleware('auth')->group(function () {

// add Teacher review******
Route::resource('/reviewTeacher','TeacherController');
Route::post('/review_Teacher','TeacherController@add_Teacher_review')->name('review_Teacher.add_Teacher_review');
//*********         End Students Reviews *************** /
/******** students Notif *************** */
Route::get('/TeacherListNotif','TeacherController@TeacherNotifList')->name('TeacherListNotif.TeacherNotifList');


/* *************** end students Notif ************/
    Route::get('/home', 'HomeController@index')->name('home');

    /************************************ Admin Routes ****************************************/
    //Teacher routes
    Route::group(['middleware' => ['auth', 'admin']],function(){
    Route::get ('/teachers_review','TeacherController@reviews')->name('teachers_review.reviews');
    Route::get ('/teachers_lists','TeacherController@lists')->name('teachers_lists.lists');
    Route::get('/teachers_index', 'TeacherController@home')->name('teachers_index.home');
    Route::get('/teachers_edit', 'TeacherController@edit')->name('teachers_edit.edit');
    Route::get('/teachers_create', 'TeacherController@create')->name('teachers_create.create');
    Route::get('/teacherss/{id}', 'TeacherController@view')->name('teacherss.view');
    Route::resource ('/teachers','TeacherController');

    //Student rootes
    Route::get ('/students_manages','StudentController@index')->name('students_manages.index');
    Route::delete ('/students/{id}','StudentController@delete')->name('students.delete');
    Route::get ('/students_create','StudentController@create')->name('students_create.create');
    Route::get ('/students_review','StudentController@reviews')->name('students_review.reviews');
    Route::get ('/students_lists','StudentController@lists')->name('students_lists.lists');
    Route::resource ('/students','StudentController');


    //Subject rootes
    Route::get ('/subjects_index','SubjectController@home')->name('subjects_index.home');
    Route::get ('/subjects_create','SubjectController@create')->name('subjects_create.create');
    Route::get ('/subjects_edit','SubjectController@edit')->name('subjects_create.edit');   
    Route::get ('/subjects_review','SubjectController@reviews')->name('subjects_review.reviews');
    Route::resource ('/subjects','SubjectController');

    //Student routes
    Route::get ('/students_review','StudentController@reviews')->name('students_review.reviews');
    Route::get ('/students_lists','StudentController@lists')->name('students_lists.lists');
    Route::resource ('/students','StudentController');

    //Subject routes
    Route::get ('/subjects_review','SubjectController@reviews')->name('subjects_review.reviews');
    Route::resource ('/subjects','SubjectController');

    //Dep rootes
    Route::get('/departments_index', 'DepartmentController@index')->name('departments_index.index');
    Route::get('/departments_show', 'DepartmentController@show')->name('departments_show.show');
    Route::get('/departments_edit', 'DepartmentController@edit')->name('departments_edit.edit');
    Route::get('/departments_create', 'DepartmentController@create')->name('departments_create.create');
    Route::resource ('/departments','DepartmentController');

    /************************************ End Admin Routes **************************************/

    //Classe routes
    Route::get('/classes_index', 'ClasseController@index')->name('classes_index.index');
    Route::get('/classes_show', 'ClasseController@show')->name('classes_show.show');
    Route::get('/classes_edit', 'ClasseController@edit')->name('classes_edit.edit');
    Route::get('/classes_create', 'ClasseController@create')->name('classes_create.create');
    Route::resource ('/classes','ClasseController');
 
    //Notif routes
    Route::post ('/store_report','NotifController@store')->name('notif.report');
    Route::post ('/notif_grp','NotifController@notif_group')->name('notif_grp.notif_group');;
    //User rootes
    Route::get ('/user_create','Auth\RegisterController@view')->name('user_create.view');
    Route::post ('/user_create','Auth\RegisterController@post')->name('user_create.post');
});

    /************************************ End Admin Routes **************************************/
    /************************************ Teacher Routes ****************************************/
    Route::group(['middleware' => ['auth', 'teacher']],function(){
    Route::resource ('/student_attendance', 'StudentAttendanceController');
    Route::resource ('/schedule', 'LessonController');
    Route::get ('/class', 'ClasseController@teacherclasselist')->name('classelist');
    Route::get ('/classe/{classid}', 'ClasseController@showstudentclasse')->name('studentclasslist');

    Route::resource ('/teacher_attendance', 'TeacherAttendanceController');
    Route::post('/class_attendance','StudentAttendanceController@addattendance')->name('class_attendance');
});
    /************************************ End Teacher Routes **************************************/

    Route::group(['middleware' => ['auth', 'student']],function(){
    /**************************************** Students Reviews ********************* */
    // add subject review******
    Route::post ('/store_report','NotifController@store')->name('notif.report');
    Route::resource ('/teachers','TeacherController');
    Route::resource('/reviewSubjectt','SubjectController');
    Route::post('/review_Subject','SubjectController@add_subject_review')->name('review_Subject.add_subject_review');
    //*********

    // add Teacher review******
    //*********         End Students Reviews *************** /
    Route::get('/noteUpdate','NotifController@seen')->name('noteUpdate.seen');
        //Schedule routes
        Route::get('/schedule_index', 'LessonController@home')->name('schedule_index.home');
        Route::get('/schedule_edit', 'LessonController@edit')->name('schedule_edit.edit');
        Route::get('/schedule_create', 'LessonController@create')->name('schedule_create.create');
        Route::resource ('/schedules', 'LessonController');
        Route::get ('/schedule_student', 'LessonController@index1')->name('schedule_student.index1');
        Route::resource ('/student_attendance', 'StudentAttendanceController');

    });
    View::composer('layouts.Menu', function( $view ){
        $user = auth::user();
        $notif= Notif::where('user_id','=',$user->id)->get();
        $nbrs=0;
        foreach($notif as $note){
            if($note->status=="new"){
                $nbrs++;
            }
        }
        $view->with(compact('user','notif','nbrs'));
    });
    Route::get('/profil','UserController@index')->name('profil');
    Route::resource('/profile','UserController');
});