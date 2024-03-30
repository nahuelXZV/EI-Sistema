<?php

use App\Livewire\Academic\Career\CreateCareer;
use App\Livewire\Academic\Career\EditCareer;
use App\Livewire\Academic\Career\ListCareer;
use App\Livewire\Academic\Course\CreateCourse;
use App\Livewire\Academic\Course\EditCourse;
use App\Livewire\Academic\Course\GradeCourse;
use App\Livewire\Academic\Course\InscriptionCourse;
use App\Livewire\Academic\Course\ListCourse;
use App\Livewire\Academic\Course\ShowCourse;
use App\Livewire\Academic\Module\CreateModule;
use App\Livewire\Academic\Module\EditModule;
use App\Livewire\Academic\Module\GradeModule;
use App\Livewire\Academic\Module\InscriptionModule;
use App\Livewire\Academic\Module\ListModule;
use App\Livewire\Academic\Module\ShowModule;
use App\Livewire\Academic\ModuleProcess\CreateModuleProcess;
use App\Livewire\Academic\ModuleProcess\EditModuleProcess;
use App\Livewire\Academic\ModuleProcess\ListModuleProcess;
use App\Livewire\Academic\Program\CreateProgram;
use App\Livewire\Academic\Program\EditProgram;
use App\Livewire\Academic\Program\InscriptionProgram;
use App\Livewire\Academic\Program\ListProgram;
use App\Livewire\Academic\Program\ModuleProgram;
use App\Livewire\Academic\Program\ShowProgram;
use App\Livewire\Academic\RegistrationRequirement\CreateRegistrationRequirement;
use App\Livewire\Academic\RegistrationRequirement\EditRegistrationRequirement;
use App\Livewire\Academic\RegistrationRequirement\ListRegistrationRequirement;
use App\Livewire\Academic\Student\CreateRequirementStudent;
use App\Livewire\Academic\Student\CreateStudent;
use App\Livewire\Academic\Student\EditStudent;
use App\Livewire\Academic\Student\GradeStudent;
use App\Livewire\Academic\Student\ListStudent;
use App\Livewire\Academic\Student\ShowStudent;
use App\Livewire\Academic\Teacher\CreateTeacher;
use App\Livewire\Academic\Teacher\EditTeacher;
use App\Livewire\Academic\Teacher\ListTeacher;
use App\Livewire\Academic\Teacher\ShowTeacher;
use App\Livewire\Academic\University\CreateUniversity;
use App\Livewire\Academic\University\EditUniversity;
use App\Livewire\Academic\University\ListUniversity;
use App\Livewire\System\Area\CreateArea;
use App\Livewire\System\Area\EditArea;
use App\Livewire\System\Area\ListArea;
use App\Livewire\System\Dashboard\Home;
use App\Livewire\System\Position\CreatePosition;
use App\Livewire\System\Position\EditPosition;
use App\Livewire\System\Position\ListPosition;
use App\Livewire\System\Role\CreateRole;
use App\Livewire\System\Role\EditRole;
use App\Livewire\System\Role\ListRole;
use App\Livewire\System\User\CreateUser;
use App\Livewire\System\User\EditUser;
use App\Livewire\System\User\ListUser;
use Illuminate\Support\Facades\Route;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', Home::class)->name('dashboard');
    Route::get('/dashboard', Home::class);

    // user routes
    Route::group(['prefix' => 'user'], function () {
        Route::get('/list', ListUser::class)->name('user.list');
        Route::get('/new', CreateUser::class)->name('user.new');
        Route::get('/edit/{user}', EditUser::class)->name('user.edit');
    });

    // role routes
    Route::group(['prefix' => 'role'], function () {
        Route::get('/list', ListRole::class)->name('role.list');
        Route::get('/new', CreateRole::class)->name('role.new');
        Route::get('/edit/{role}', EditRole::class)->name('role.edit');
    });

    // position routes
    Route::group(['prefix' => 'position'], function () {
        Route::get('/list', ListPosition::class)->name('position.list');
        Route::get('/new', CreatePosition::class)->name('position.new');
        Route::get('/edit/{position}', EditPosition::class)->name('position.edit');
    });

    // area routes
    Route::group(['prefix' => 'area'], function () {
        Route::get('/list', ListArea::class)->name('area.list');
        Route::get('/new', CreateArea::class)->name('area.new');
        Route::get('/edit/{area}', EditArea::class)->name('area.edit');
    });

    // program router
    Route::group(['prefix' => 'program'], function () {
        Route::get('/list', ListProgram::class)->name('program.list');
        Route::get('/new', CreateProgram::class)->name('program.new');
        Route::get('/edit/{program}', EditProgram::class)->name('program.edit');
        Route::get('/show/{program}', ShowProgram::class)->name('program.show');
        Route::get('/module/{module}', ModuleProgram::class)->name('program.module');

        // inscriptions
        Route::get('/inscription/{program}', InscriptionProgram::class)->name('program.inscription');
    });

    // module router
    Route::group(['prefix' => 'module'], function () {
        Route::get('/new/{program}', CreateModule::class)->name('module.new');
        Route::get('/edit/{module}', EditModule::class)->name('module.edit');
        Route::get('/inscription/{module}', InscriptionModule::class)->name('module.inscription');
        Route::get('/grade/{module}', GradeModule::class)->name('module.grade');
    });

    // teacher router
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/list', ListTeacher::class)->name('teacher.list');
        Route::get('/new', CreateTeacher::class)->name('teacher.new');
        Route::get('/edit/{teacher}', EditTeacher::class)->name('teacher.edit');
        Route::get('/show/{teacher}', ShowTeacher::class)->name('teacher.show');
    });

    // student router
    Route::group(['prefix' => 'student'], function () {
        Route::get('/list', ListStudent::class)->name('student.list');
        Route::get('/new', CreateStudent::class)->name('student.new');
        Route::get('/edit/{student}', EditStudent::class)->name('student.edit');
        Route::get('/show/{student}', ShowStudent::class)->name('student.show');

        Route::get('/requirement/{student}/requirement', CreateRequirementStudent::class)->name('student.requirement');
        Route::get('/grade/{student}/{program}', GradeStudent::class)->name('student.grade');
    });

    // university routes
    Route::group(['prefix' => 'university'], function () {
        Route::get('/list', ListUniversity::class)->name('university.list');
        Route::get('/new', CreateUniversity::class)->name('university.new');
        Route::get('/edit/{university}', EditUniversity::class)->name('university.edit');
    });

    // career routes
    Route::group(['prefix' => 'career'], function () {
        Route::get('/list', ListCareer::class)->name('career.list');
        Route::get('/new', CreateCareer::class)->name('career.new');
        Route::get('/edit/{career}', EditCareer::class)->name('career.edit');
    });

    // module-process routes
    Route::group(['prefix' => 'process'], function () {
        Route::get('/list', ListModuleProcess::class)->name('process.list');
        Route::get('/new', CreateModuleProcess::class)->name('process.new');
        Route::get('/edit/{process}', EditModuleProcess::class)->name('process.edit');
    });

    // registration-requirement routes
    Route::group(['prefix' => 'requirement'], function () {
        Route::get('/list', ListRegistrationRequirement::class)->name('requirement.list');
        Route::get('/new', CreateRegistrationRequirement::class)->name('requirement.new');
        Route::get('/edit/{requirement}', EditRegistrationRequirement::class)->name('requirement.edit');
    });

     // course routes
     Route::group(['prefix' => 'course'], function () {
        Route::get('/list', ListCourse::class)->name('course.list');
        Route::get('/new', CreateCourse::class)->name('course.new');
        Route::get('/edit/{course}', EditCourse::class)->name('course.edit');
        Route::get('/show/{course}', ShowCourse::class)->name('course.show');
        Route::get('/inscription/{course}', InscriptionCourse::class)->name('course.inscription');
        Route::get('/grade/{course}', GradeCourse::class)->name('course.grade');
    });
});
