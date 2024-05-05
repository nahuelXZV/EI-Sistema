<?php

use App\Livewire\Academic\AreaProfession\CreateAreaProfession;
use App\Livewire\Academic\AreaProfession\EditAreaProfession;
use App\Livewire\Academic\AreaProfession\ListAreaProfession;
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
use App\Livewire\Academic\Teacher\CreateAreaTeacher;
use App\Livewire\Academic\Teacher\CreateTeacher;
use App\Livewire\Academic\Teacher\EditTeacher;
use App\Livewire\Academic\Teacher\ListTeacher;
use App\Livewire\Academic\Teacher\ShowTeacher;
use App\Livewire\Academic\University\CreateUniversity;
use App\Livewire\Academic\University\EditUniversity;
use App\Livewire\Academic\University\ListUniversity;
use App\Livewire\Accounting\DiscountType\CreateDiscountType;
use App\Livewire\Accounting\DiscountType\EditDiscountType;
use App\Livewire\Accounting\DiscountType\ListDiscountType;
use App\Livewire\Accounting\Pay\CreatePay;
use App\Livewire\Accounting\Pay\EditPay;
use App\Livewire\Accounting\Pay\ShowPay;
use App\Livewire\Accounting\PaymentType\CreatePaymentType;
use App\Livewire\Accounting\PaymentType\EditPaymentType;
use App\Livewire\Accounting\PaymentType\ListPaymentType;
use App\Livewire\Accounting\ProgramPayment\EditProgramPayment;
use App\Livewire\Accounting\ProgramPayment\ListProgramPayment;
use App\Livewire\Accounting\ProgramPayment\ShowProgramPayment;
use App\Livewire\System\Area\CreateArea;
use App\Livewire\System\Area\EditArea;
use App\Livewire\System\Area\ListArea;
use App\Livewire\System\Dashboard\Home;
use App\Livewire\System\Imports\CreateImport;
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
    Route::get('/imports', CreateImport::class)->name('imports')->middleware('can:importar.index');

    // user routes
    Route::group(
        ['prefix' => 'user', 'middleware' => ['can:usuario.index']],
        function () {
            Route::get('/list', ListUser::class)->name('user.list');
            Route::get('/new', CreateUser::class)->name('user.new');
            Route::get('/edit/{user}', EditUser::class)->name('user.edit');
        }
    );

    // role routes
    Route::group(['prefix' => 'role', 'middleware' => ['can:roles.index']], function () {
        Route::get('/list', ListRole::class)->name('role.list');
        Route::get('/new', CreateRole::class)->name('role.new');
        Route::get('/edit/{role}', EditRole::class)->name('role.edit');
    });

    // position routes
    Route::group(['prefix' => 'position', 'middleware' => ['can:cargo.index']], function () {
        Route::get('/list', ListPosition::class)->name('position.list');
        Route::get('/new', CreatePosition::class)->name('position.new');
        Route::get('/edit/{position}', EditPosition::class)->name('position.edit');
    });

    // area routes
    Route::group(['prefix' => 'area', 'middleware' => ['can:area.index']], function () {
        Route::get('/list', ListArea::class)->name('area.list');
        Route::get('/new', CreateArea::class)->name('area.new');
        Route::get('/edit/{area}', EditArea::class)->name('area.edit');
    });

    // program router
    Route::group(['prefix' => 'program', 'middleware' => ['can:programa.index']], function () {
        Route::get('/list', ListProgram::class)->name('program.list');
        Route::get('/new', CreateProgram::class)->name('program.new');
        Route::get('/edit/{program}', EditProgram::class)->name('program.edit');
        Route::get('/show/{program}', ShowProgram::class)->name('program.show');
        Route::get('/module/{module}', ModuleProgram::class)->name('program.module');

        // inscriptions
        Route::get('/inscription/{program}', InscriptionProgram::class)->name('program.inscription');
    });

    // module router
    Route::group(['prefix' => 'module', 'middleware' => ['can:modulo.index']], function () {
        Route::get('/new/{program}', CreateModule::class)->name('module.new');
        Route::get('/edit/{module}', EditModule::class)->name('module.edit');
        Route::get('/inscription/{module}', InscriptionModule::class)->name('module.inscription');
        Route::get('/grade/{module}', GradeModule::class)->name('module.grade');
    });

    // area profession routes
    Route::group(['prefix' => 'area-profession', 'middleware' => ['can:docentes.index']], function () {
        Route::get('/list', ListAreaProfession::class)->name('area-profession.list');
        Route::get('/new', CreateAreaProfession::class)->name('area-profession.new');
        Route::get('/edit/{area}', EditAreaProfession::class)->name('area-profession.edit');
    });

    // teacher router
    Route::group(['prefix' => 'teacher', 'middleware' => ['can:docentes.index']], function () {
        Route::get('/list', ListTeacher::class)->name('teacher.list');
        Route::get('/new', CreateTeacher::class)->name('teacher.new');
        Route::get('/edit/{teacher}', EditTeacher::class)->name('teacher.edit');
        Route::get('/show/{teacher}', ShowTeacher::class)->name('teacher.show');
        Route::get('/area-profession/{teacher}', CreateAreaTeacher::class)->name('teacher.area');
    });

    // student router
    Route::group(['prefix' => 'student', 'middleware' => ['can:estudiante.index']], function () {
        Route::get('/list', ListStudent::class)->name('student.list');
        Route::get('/new', CreateStudent::class)->name('student.new');
        Route::get('/edit/{student}', EditStudent::class)->name('student.edit');
        Route::get('/show/{student}', ShowStudent::class)->name('student.show');

        Route::get('/requirement/{student}/requirement', CreateRequirementStudent::class)->name('student.requirement');
        Route::get('/grade/{student}/{program}', GradeStudent::class)->name('student.grade');
    });

    // university routes
    Route::group(['prefix' => 'university', 'middleware' => ['can:universidad.index']], function () {
        Route::get('/list', ListUniversity::class)->name('university.list');
        Route::get('/new', CreateUniversity::class)->name('university.new');
        Route::get('/edit/{university}', EditUniversity::class)->name('university.edit');
    });

    // career routes
    Route::group(['prefix' => 'career', 'middleware' => ['can:carreras.index']], function () {
        Route::get('/list', ListCareer::class)->name('career.list');
        Route::get('/new', CreateCareer::class)->name('career.new');
        Route::get('/edit/{career}', EditCareer::class)->name('career.edit');
    });

    // module-process routes
    Route::group(['prefix' => 'process', 'middleware' => ['can:procesos.index']], function () {
        Route::get('/list', ListModuleProcess::class)->name('process.list');
        Route::get('/new', CreateModuleProcess::class)->name('process.new');
        Route::get('/edit/{process}', EditModuleProcess::class)->name('process.edit');
    });

    // registration-requirement routes
    Route::group(['prefix' => 'requirement', 'middleware' => ['can:requisito.index']], function () {
        Route::get('/list', ListRegistrationRequirement::class)->name('requirement.list');
        Route::get('/new', CreateRegistrationRequirement::class)->name('requirement.new');
        Route::get('/edit/{requirement}', EditRegistrationRequirement::class)->name('requirement.edit');
    });

    // course routes
    Route::group(['prefix' => 'course', 'middleware' => ['can:cursos.index']], function () {
        Route::get('/list', ListCourse::class)->name('course.list');
        Route::get('/new', CreateCourse::class)->name('course.new');
        Route::get('/edit/{course}', EditCourse::class)->name('course.edit');
        Route::get('/show/{course}', ShowCourse::class)->name('course.show');
        Route::get('/inscription/{course}', InscriptionCourse::class)->name('course.inscription');
        Route::get('/grade/{course}', GradeCourse::class)->name('course.grade');
    });

    // payment type routes
    Route::group(['prefix' => 'payment-type'], function () {
        Route::get('/list', ListPaymentType::class)->name('payment-type.list');
        Route::get('/new', CreatePaymentType::class)->name('payment-type.new');
        Route::get('/edit/{payment_type}', EditPaymentType::class)->name('payment-type.edit');
    });

    // discount type routes
    Route::group(['prefix' => 'discount-type'], function () {
        Route::get('/list', ListDiscountType::class)->name('discount-type.list');
        Route::get('/new', CreateDiscountType::class)->name('discount-type.new');
        Route::get('/edit/{discount_type}', EditDiscountType::class)->name('discount-type.edit');
    });

    // program payment routes
    Route::group(['prefix' => 'program-payment'], function () {
        Route::get('/list', ListProgramPayment::class)->name('program-payment.list');
        Route::get('/edit/{program_payment}', EditProgramPayment::class)->name('program-payment.edit');
        Route::get('/show/{student}', ShowProgramPayment::class)->name('program-payment.show');
    });

    // pay routes
    Route::group(['prefix' => 'pay'], function () {
        Route::get('/create/{type}/{paymentId}', CreatePay::class)->name('pay.create');
        Route::get('/show/{type}/{paymentId}', ShowPay::class)->name('pay.show');
        Route::get('/edit/{type}/{pay}', EditPay::class)->name('pay.edit');
    });
});
