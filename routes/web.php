<?php

use App\Models\Faculties;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubjectStudentController;
use App\Http\Controllers\SupervisorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/student-home', [HomeController::class, 'studentDashboard'])->name('studentDashboard');
Route::get('/peer-home', [HomeController::class, 'peerDashboard'])->name('peerDashboard');
Route::get('/supervisor-home', [HomeController::class, 'supervisorDashboard'])->name('supervisorDashboard');

Route::group(['middleware' => ['auth:web']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/edit/profile', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::put('/edit/profile/{id}', [UserController::class, 'updateProfile'])->name('update.profile');

    //Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/update/{keyName}', [SettingsController::class, 'update']);

    //Academic Year
    Route::get('/academic/year', [AcademicYearController::class, 'index'])->name('academic.year');
    Route::get('/academic/year/create', [AcademicYearController::class, 'create'])->name('academic.year.create');
    Route::post('/academic/year/store', [AcademicYearController::class, 'store'])->name('academic.year.store');
    Route::get('/academic/year/{id}', [AcademicYearController::class, 'edit'])->name('academic.year.edit');
    Route::put('/academic/year/{id}', [AcademicYearController::class, 'update'])->name('academic.year.update');
    Route::delete('/academic/year/{id}', [AcademicYearController::class, 'delete'])->name('academic.year.delete');
    Route::put('/academic/update-evaluation-status/{id}', [AcademicYearController::class, 'updateEvaluationStatus'])->name('academic.year.updateEvalStatus');
    Route::put('/academic/updateDefaultStatus/{id}', [AcademicYearController::class, 'updateDefaultStatus'])->name('academic.year.updateDefaultStatus');

    //Classes
    Route::get('/classes', [ClassesController::class, 'index'])->name('classes');
    Route::post('/classes/store', [ClassesController::class, 'store'])->name('classes.store');
    Route::get('/classes/{id}', [ClassesController::class, 'edit'])->name('classes.edit');
    Route::put('/classes/{id}', [ClassesController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{id}', [ClassesController::class, 'delete'])->name('classes.delete');

    //Subject
    Route::post('/subject', [SubjectController::class, 'store'])->name('subject.store');
    Route::get('/subject/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::put('/subject/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subject/{id}', [SubjectController::class, 'delete'])->name('subject.delete');

    //Departments
    Route::get('/department', [DepartmentController::class, 'index'])->name('department');
    Route::post('/department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/department/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::put('/department/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/department/{id}', [DepartmentController::class, 'delete'])->name('department.delete');

    //SuperVisor
    Route::get('/supervisor', [SupervisorController::class, 'index'])->name('supervisor');
    Route::post('/supervisor', [SupervisorController::class, 'store'])->name('supervisor.store');
    Route::get('/supervisor/{id}', [SupervisorController::class, 'edit'])->name('supervisor.edit');
    Route::put('/supervisor/{id}', [SupervisorController::class, 'update'])->name('supervisor.update');
    Route::delete('/supervisor/{id}', [SupervisorController::class, 'delete'])->name('supervisor.delete');

    //Faculty
    Route::post('/faculty', [FacultyController::class, 'store'])->name('faculty.store');
    Route::get('/faculty/{id}', [FacultyController::class, 'edit'])->name('faculty.edit');
    Route::put('/faculty/{id}', [FacultyController::class, 'update'])->name('faculty.update');
    Route::delete('/faculty/{id}', [FacultyController::class, 'delete'])->name('faculty.delete');

    //SubjectStudents
    Route::get('/students/{subjectId}', [SubjectStudentController::class, 'index'])->name('subject.students');
    Route::post('/import/students', [SubjectStudentController::class, 'importStudents'])->name('students.import');

    //Students
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/student/{id}/{subjectId}', [StudentController::class, 'delete'])->name('student.delete');

    //Criteria
    Route::get('/criteria', [CriteriaController::class, 'index'])->name('criteria');
    Route::post('/criteria/store', [CriteriaController::class, 'store'])->name('criteria.store');
    Route::get('/criteria/{id}', [CriteriaController::class, 'edit'])->name('criteria.edit');
    Route::put('/criteria/{id}', [CriteriaController::class, 'update'])->name('criteria.update');
    Route::delete('/criteria/{id}', [CriteriaController::class, 'delete'])->name('criteria.delete');
    Route::patch('/update-criteria-order/{id}', [CriteriaController::class, 'updateOrder']);

     //Questions
    Route::get('/question', [QuestionController::class, 'index'])->name('question');
    Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/question/{id}', [QuestionController::class, 'edit'])->name('question.edit');
    Route::put('/question/{id}', [QuestionController::class, 'update'])->name('question.update');
    Route::delete('/question/{id}', [QuestionController::class, 'delete'])->name('question.delete');

    //Classes
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations');
    Route::get('/evaluation/for/evaluators', [EvaluationController::class, 'evaluatorsEvaluationPage'])->name('evaluatorsEvaluationPage');
    Route::get('/evaluations/dataTableList/{type}', [EvaluationController::class, 'dataTableList'])->name('evaluations.dataTableList');
    Route::post('/evaluations/store', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::post('/evaluations/submit/{evaluationId}', [EvaluationController::class, 'submitEvaluation'])->name('evaluations.submitEvaluation');
    Route::get('/evaluations/{id}', [EvaluationController::class, 'edit'])->name('evaluations.edit');
    Route::put('/evaluations/{id}', [EvaluationController::class, 'update'])->name('evaluations.update');
    Route::delete('/evaluations/{id}', [EvaluationController::class, 'delete'])->name('evaluations.delete');
    Route::get('/evaluate/{assignmentId}/{id}', [EvaluationController::class, 'evaluate'])->name('evaluations.form');
    Route::get('/evaluation/result/{assignmentId}/{evaluationId}', [EvaluationController::class, 'evaluationResult'])->name('evaluations.result');
    Route::post('/evaluation/students/assignment', [EvaluationController::class, 'assignStudents'])->name('evaluations.student.assigment');
    Route::post('/evaluation/peers/assignment', [EvaluationController::class, 'assignPeers'])->name('evaluations.peer.assigment');
    Route::post('/evaluation/supervisor/assignment', [EvaluationController::class, 'assignSupervisor'])->name('evaluations.supervisor.assigment');

    //Reports
    Route::get('/evaluation/comments/{evaluationId}', [ReportsController::class, 'comments'])->name('evaluations.comments');
    Route::get('/evaluation/print/comments/{evaluationId}', [ReportsController::class, 'printComments'])->name('evaluations.print.comments');
    Route::get('/evaluation/print/performance/{evaluationId}', [ReportsController::class, 'printEvaluationPerformance'])->name('evaluations.print.performance');


    Route::get('/all/students/{faculty_id}', function ($faculty_id) {
        $faculty = Faculties::with(['subjects.students' => function ($query) {
            // Order students alphabetically by name
            $query->orderBy('last_name');
        }])->find($faculty_id);

        $uniqueStudentsIds = collect();

        // Loop through subjects and students to get unique students
        foreach ($faculty->subjects as $subject) {
            $uniqueStudentsIds = $uniqueStudentsIds->merge($subject->students->pluck('id'));
        }

        // Unique student IDs
        $uniqueStudentsIds = $uniqueStudentsIds->unique()->values()->toArray();
    });
});
