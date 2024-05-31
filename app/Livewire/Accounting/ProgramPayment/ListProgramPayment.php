<?php

namespace App\Livewire\Accounting\ProgramPayment;

use App\Exports\StudentDebtExport;
use App\Services\Academic\StudentService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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
    public $exportFormat = ''; // Default export format is empty
    public $exportFormats = ['pdf', 'excel'];

    public function mount()
    {
    }

    public function allStudents()
    {
        $this->hasDebt = false;
        if ($this->exportFormat) {
            return $this->download('all');
        } else {
            $this->render();
        }
    }

    public function hasDebtFunction()
    {
        $this->hasDebt = true;
        if ($this->exportFormat) {
            return $this->download('debt');
        } else {
            $this->render();
        }
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->search = '';
        $this->type = '';
    }

    public function download($type)
    {
        if ($type === 'all') {
            if ($this->exportFormat === 'pdf') {
                return redirect()->route('student-debt.pdf', ['all']);
            } elseif ($this->exportFormat === 'excel') {
                return Excel::download(new StudentDebtExport($this->hasDebt), 'students.xlsx');
            }
        } elseif ($type === 'debt') {
            if ($this->exportFormat === 'pdf') {
                return redirect()->route('student-debt.pdf', ['debt']);
            } elseif ($this->exportFormat === 'excel') {
                return Excel::download(new StudentDebtExport($this->hasDebt), 'students-debt.xlsx');
            }
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
        return view('livewire.accounting.program-payment.list-program-payment', compact('students'));
    }
}
