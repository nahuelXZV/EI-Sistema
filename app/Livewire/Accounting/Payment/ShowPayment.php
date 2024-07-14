<?php

namespace App\Livewire\Accounting\Payment;

use App\Services\Academic\StudentService;
use App\Services\Accounting\CoursePaymentService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPayment extends Component
{
    use WithPagination;
    public $breadcrumbs;
    public $student;

    public function mount($student)
    {
        $this->student = StudentService::getOne($student);
        $this->checkPayments($student);
        $this->breadcrumbs = [
            ['title' => "Contabilidad", "url" => "payment.list"],
            ['title' => "Estudiantes", "url" => "payment.show"]
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
        $programs = ProgramPaymentService::getAllByStudent($this->student->id);
        $courses = CoursePaymentService::getAllByStudent($this->student->id);
        return view('livewire.accounting.payment.show-payment', compact('programs', 'courses'));
    }
}
