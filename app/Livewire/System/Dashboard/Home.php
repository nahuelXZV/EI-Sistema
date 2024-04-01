<?php

namespace App\Livewire\System\Dashboard;

use App\Constants\ProgramsTypes;
use App\Constants\StateStudent;
use App\Models\Course;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use App\Services\System\DashboardService;
use Livewire\Component;

class Home extends Component
{
    public $breadcrumbs = [];
    public $cantStateStudents, $stateStudents;
    public $cantProgramTypes, $programTypes;
    public $cantUsersbyRole;

    public function render()
    {
        $now = now();
        $now = $now->format('Y-m-d');
        $students = Student::where('estado', StateStudent::ACTIVE )->get()->count();
        $courses = Course::where('fecha_final', '>', $now)->get()->count();
        $programs = Program::where('fecha_final', '>', $now)->get()->count();
        $users = User::all()->count();

        $this->stateStudents = StateStudent::all();
        $this->cantStateStudents = DashboardService::getStateTypes($this->stateStudents);
        $this->programTypes = ProgramsTypes::all();
        $this->cantProgramTypes = DashboardService::getProgramTypes($this->programTypes);
        $this->cantUsersbyRole = DashboardService::getUsersByRole();

        return view('livewire.system.dashboard.home', compact('students', 'courses', 'programs', 'users'));
    }
}
