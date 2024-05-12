<?php

namespace App\Livewire\Accounting\ProgramPayment;

use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class ListProgramPayment extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Estudiantes", "url" => "program-payment.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';
    public $hasDebt = false;

    public function mount()
    {
    }

    public function allStudents()
    {
        $this->hasDebt = false;
        $this->render();
    }

    public function hasDebtFunction()
    {
        $this->hasDebt = true;
        $this->render();
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->search = '';
        $this->type = '';
    }

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = ProgramPaymentService::getAllStudentPaginate($this->search, 15);
        return view('livewire.accounting.program-payment.list-program-payment', compact('students'));
    }
}
