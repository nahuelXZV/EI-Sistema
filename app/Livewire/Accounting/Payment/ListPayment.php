<?php

namespace App\Livewire\Accounting\Payment;

use App\Exports\StudentDebtExport;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ListPayment extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Estudiantes", "url" => "payment.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';
    public $hasDebt = false;
    public $allTitle = "Todos";
    public $debtTitle = "Deudores";
    public $title = "Todos";

    public function mount()
    {
    }

    public function allStudents()
    {
        $this->hasDebt = false;
        $this->title = $this->allTitle;
        $this->render();
    }

    public function hasDebtFunction()
    {
        $this->hasDebt = true;
        $this->title = $this->debtTitle;
        $this->render();
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->search = '';
        $this->type = '';
    }

    public function exportExcel()
    {
        if ($this->hasDebt === false) {
            return Excel::download(new StudentDebtExport($this->hasDebt), 'students.xlsx');
        } else {
            return Excel::download(new StudentDebtExport($this->hasDebt), 'students-debt.xlsx');
        }
    }

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->hasDebt) {
            $students = ProgramPaymentService::getAllStudentPaginateDebt($this->search, 15);
        } else {
            $students = ProgramPaymentService::getAllStudentPaginate($this->search, 15);
        }
        return view('livewire.accounting.payment.list-payment', compact('students'));
    }
}
