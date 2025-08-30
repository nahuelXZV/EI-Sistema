<?php

namespace App\Livewire\Accounting\Pay;

use App\Models\DiscountType;
use App\Services\Academic\ModuleInscriptionService;
use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramService;
use App\Services\Academic\StudentService;
use App\Services\Accounting\DiscountTypeService;
use App\Services\Accounting\PayService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPayProgram extends Component
{
    use WithPagination;

    public $student;
    public $program;
    public $modules;
    public $discountApplied;
    public $payment;
    public $discount; // descuento
    public $amountPaid; // monto pagado
    public $amountOwed;  // monto adeudado
    public $paidDue; // pagado por vencer
    public $amountTotal; // monto total
    public $debt; // deuda
    public $numberModulesInProgress;

    public function mount($paymentId)
    {
        $this->payment = ProgramPaymentService::getOne($paymentId);
        $this->discountApplied = DiscountTypeService::getOne($this->payment->tipo_descuento_id);
        $this->program = ProgramService::getOne($this->payment->programa_id);
        $this->student = StudentService::getOne($this->payment->estudiante_id);
        $this->modules = ModuleInscriptionService::getAllByStudentAndProgram($this->student->id, $this->program->id);
        $this->numberModulesInProgress = ModuleService::getNumberModulesInProgress($this->program->id);
        $this->checkDebt();
    }

    private function checkDebt()
    {
        $checkDebt = ProgramPaymentService::checkDebt($this->payment->id);
        $this->discount = $checkDebt['discount'];
        $this->amountTotal = $checkDebt['amountTotal'];
        $this->amountPaid = $checkDebt['amountPaid'];
        $this->amountOwed = $checkDebt['amountOwed'];
        $this->paidDue = $checkDebt['paidDue'];
        $this->debt = $checkDebt['debt'];
        $this->payment = ProgramPaymentService::getOne($this->payment->id);
    }

    public function delete($id)
    {
        PayService::delete($id);
        $this->checkDebt();
        return redirect()->route('pay.show', ['program', $this->payment->id]);
    }


    public function render()
    {
        $payments = PayService::getAllPaginateByProgramPayment($this->payment->id, 10);
        $payments->map(function ($payment) {
            $payment->acumulado = PayService::getMountByProgramPayment($this->payment->id, $payment->id);
            return $payment;
        });
        return view('livewire.accounting.pay.show-pay-program', compact('payments'));
    }
}
