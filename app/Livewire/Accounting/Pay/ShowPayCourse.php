<?php

namespace App\Livewire\Accounting\Pay;

use App\Services\Academic\CourseService;
use App\Services\Academic\StudentService;
use App\Services\Accounting\CoursePaymentService;
use App\Services\Accounting\PayService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPayCourse extends Component
{
    use WithPagination;

    public $student;
    public $course;
    public $modules;
    public $payment;
    public $discount; // descuento
    public $amountPaid; // monto pagado
    public $amountTotal; // monto total
    public $debt; // deuda
    public $numberModulesInProgress;

    public function mount($paymentId)
    {
        $this->payment = CoursePaymentService::getOne($paymentId);
        $this->course = CourseService::getOne($this->payment->curso_id);
        $this->student = StudentService::getOne($this->payment->estudiante_id);
        $this->checkDebt();
    }

    private function checkDebt($updateState = false)
    {
        $checkDebt = CoursePaymentService::checkDebt($this->payment->id, $updateState);
        $this->discount = $checkDebt['discount'];
        $this->amountTotal = $checkDebt['amountTotal'];
        $this->amountPaid = $checkDebt['amountPaid'];
        $this->debt = $checkDebt['debt'];
    }

    public function delete($id)
    {
        PayService::delete($id);
        $this->checkDebt(true);
        return redirect()->route('pay.show', ['course', $this->payment->id]);
    }


    public function render()
    {
        $payments = PayService::getAllPaginateByCoursePayment($this->payment->id, 10);
        $payments->map(function ($payment) {
            $payment->acumulado = PayService::getMountByCoursePayment($this->payment->id, $payment->id);
            return $payment;
        });
        return view('livewire.accounting.pay.show-pay-course', compact('payments'));
    }
}
