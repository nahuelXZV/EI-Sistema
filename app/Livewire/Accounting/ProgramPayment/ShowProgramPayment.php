<?php

namespace App\Livewire\Accounting\ProgramPayment;

use App\Services\Academic\StudentService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProgramPayment extends Component
{
    use WithPagination;
    public $breadcrumbs;
    public $student;

    public function mount($student)
    {
        $this->student = StudentService::getOne($student);
        $this->checkPayments($student);
        $this->breadcrumbs = [
            ['title' => "Contabilidad", "url" => "program-payment.list"],
            ['title' => "Estudiantes", "url" => "program-payment.show"]
        ];
    }

    public function checkPayments($id)
    {
        $hasDebt = ProgramPaymentService::hasDebt($id);
        if ($hasDebt) {
            $this->student->tiene_deuda = true;
            $this->student->save();
        } else {
            $this->student->tiene_deuda = false;
            $this->student->save();
        }
    }

    public function render()
    {
        $payments = ProgramPaymentService::getAllByStudent($this->student->id);
        return view('livewire.accounting.program-payment.show-program-payment', compact('payments'));
    }
}
