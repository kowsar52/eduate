<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\checkRole;
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
Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    return "Cache is cleared";
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin', function () {
    return view('admin_login');
});

//auth routing
Route::post('/login/post','auth\UserController@login');
Route::post('/user/login/post','auth\UserController@userLogin');
Route::get('/user/logout','auth\UserController@userLogout');


//admin dashboard routing
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard','DashboardController@adminDashboard');
    Route::get('getSchools','SuperAdminController@getSchool');
    Route::post('addSchool','SuperAdminController@addSchool');
    Route::post('activeDeactive','SuperAdminController@activeDeactive');
    Route::post('schoolDetails','SuperAdminController@schoolDetails');

    Route::get('profile','ProfileController@adminIndex');



});

//principal dashboard routing
Route::middleware(['auth', 'principal'])->prefix('principal')->group(function () {
    Route::get('dashboard','DashboardController@principalDashboard');
    Route::get('allTeachers','principal\TeacherController@getTeacher');
    Route::post('addTeacher','principal\TeacherController@addTeacher');
    Route::post('teacher/delete','principal\TeacherController@deleteTeacher');
    Route::post('teacher/editData','principal\TeacherController@editData');
    Route::get('getSubject','principal\SubjectController@getSubject');

    Route::get('allClasses/','principal\ClassController@index');
    Route::post('allClasses','principal\ClassController@allClasses');
    Route::post('addClass','principal\ClassController@addClass');
    Route::post('class/edit','principal\ClassController@editClass');
    Route::post('class/delete','principal\ClassController@deleteClass');

    Route::post('getSection','principal\SectionController@getSection');
    Route::get('section/{id}','principal\SectionController@index');
    Route::post('section/add','principal\SectionController@addSection');
    Route::post('section/assignTeacher','principal\SectionController@assignTeacher');
    Route::post('section/editData','principal\SectionController@editData');
    Route::post('section/delete','principal\SectionController@deleteSection');

    
    Route::get('profile','ProfileController@principalIndex');
    
    Route::get('allSubjects','principal\SubjectController@index');
    Route::get('subject/{id}','principal\SubjectController@getSubjectPage');
    Route::post('getSubject','principal\SubjectController@getSubject');
    Route::post('addSubject','principal\SubjectController@addSubject');
    Route::post('subjectDelete','principal\SubjectController@deleteSubject');

   

    Route::get('createExam','principal\ExamController@index');
    Route::get('getExams','principal\ExamController@getExams');
    Route::post('addexam','principal\ExamController@addexam');
    Route::post('getEditData','principal\ExamController@getEditData');
    Route::post('examDelete','principal\ExamController@examDelete');


    Route::get('allModerators','principal\ModaratorController@index');
    Route::get('getModerators','principal\ModaratorController@getModerators');
    Route::post('addModarator','principal\ModaratorController@addModarator');
    Route::post('deleteModarator','principal\ModaratorController@deleteModarator');


    Route::get('sectionWiseStudent','principal\StudentController@index');
    Route::get('getStudents','principal\StudentController@getStudents');
    Route::post('addStudent','principal\StudentController@addStudent');
    Route::post('student/getEditData','principal\StudentController@getEditData');
    Route::post('deletStudent','principal\StudentController@deletStudent');
    Route::get('exportStudent/{section_id}','principal\StudentController@exportStudent');

    Route::get('allStudents','principal\OtherController@getAllStudents');

    Route::get('profile/student/{id}','ProfileController@studentIndexPri');
    Route::get('profile/teacher/{id}','ProfileController@teacherIndexPri');

    Route::get('assignTeacher','principal\AssignTeachController@index');
    Route::get('getAssignTeacher','principal\AssignTeachController@getAssignTeacher');
    Route::post('assignTeacher/save','principal\AssignTeachController@saveAssignTeacher');
    Route::post('assignTeacher/edit','principal\AssignTeachController@editData');
    Route::get('getAssignData','principal\AssignTeachController@getAssignData');
    Route::post('assignTechDelete','principal\AssignTeachController@assignTechDelete');


    Route::get('routine','principal\RoutineController@index');
    Route::get('getRoutine','principal\RoutineController@index');
    Route::post('routine/getSection','principal\RoutineController@getSection');
    Route::post('addRoutine','principal\RoutineController@addRoutine');
    Route::get('routine/downlaod/{id}','principal\RoutineController@downlaodRoutine');
    Route::post('routine/delete','principal\RoutineController@delete');

    
    
    Route::get('notice','principal\NoticeController@index');
    Route::post('notice/getClass','principal\NoticeController@getClass');
    Route::post('addNotice','principal\NoticeController@addNotice');
    Route::get('notice/downlaod/{id}','principal\NoticeController@downlaodNotice');
    Route::post('notice/delete','principal\NoticeController@delete');
    
    Route::get('transaction','principal\TransactionController@index');
    Route::post('transaction/getStd','principal\TransactionController@getStd');
    Route::post('transaction/add','principal\TransactionController@addTransaction');
    Route::get('trasnsaction/history','principal\TransactionController@getHistory');
    Route::post('transaction/history/editData','principal\TransactionController@editData');
    Route::post('transaction/history/edit','principal\TransactionController@edit');

    Route::get('contact','principal\ContactController@index');
    Route::post('contactList','principal\ContactController@contactList');
});

//principal dashboard routing
Route::middleware(['student'])->prefix('student')->group(function () {
    Route::get('dashboard','DashboardController@studentDashboard');
    Route::get('profile','ProfileController@studentIndex');


});

//principal dashboard routing
Route::middleware(['stuff'])->prefix('stuff')->group(function () {
    Route::get('dashboard','DashboardController@stuffDashboard');
    Route::get('profile','stuff\ProfileController@index');
    Route::post('profile/getEditData','stuff\ProfileController@getEditData');
    Route::post('profile/update','stuff\ProfileController@update');

    Route::get('homeTask','stuff\ProfileController@update');

    Route::get('myClasses','stuff\ClassController@index');
    Route::get('getClass','stuff\ClassController@getClass');

    Route::get('notice','stuff\NoticeController@index');
    Route::get('notice/downlaod/{id}','stuff\NoticeController@downlaodNotice');

    Route::get('routine','stuff\RoutineController@index');
    Route::get('routine/downlaod/{id}','stuff\RoutineController@downlaodRoutine');

    Route::get('contact','stuff\ContactController@index');
    Route::post('contactList','stuff\ContactController@contactList');

    Route::get('transaction','stuff\TransactionController@index');
    
    Route::get('profile/student/{id}','stuff\ProfileController@studentIndexPri');
    Route::get('profile/teacher/{id}','stuff\ProfileController@teacherIndexPri');


});

// get profile edit data 
Route::post('profile/getEditData','ProfileController@getEditData');
Route::post('profile/update','ProfileController@update');


Auth::routes();
Route::get('changePassword','auth\ChangePassController@index');
Route::post('changePassword','auth\ChangePassController@changePass');