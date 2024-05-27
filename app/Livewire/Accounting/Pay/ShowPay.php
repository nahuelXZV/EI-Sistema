<?php

namespace App\Livewire\Accounting\Pay;

use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramService;
use App\Services\Academic\StudentService;
use App\Services\Accounting\DiscountTypeService;
use App\Services\Accounting\PaymentTypeService;
use App\Services\Accounting\PayService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPay extends Component
{
    use WithPagination;
    public $breadcrumbs;

    public $student;
    public $program;
    public $payment;
    public $discount; // descuento
    public $amountPaid; // monto pagado
    public $amountOwed;  // monto adeudado
    public $paidDue; // pagado por vencer
    public $amountTotal; // monto total
    public $debt; // deuda
    public $numberModulesInProgress;

    public function mount($type, $paymentId)
    {
        $this->payment = $this->getPayment($type, $paymentId);
        $this->program = ProgramService::getOne($this->payment->programa_id);
        $this->discount = PayService::getDiscount($this->payment->tipo_descuento_id, $this->program->costo);
        $this->amountPaid = PayService::getAmountPaid($this->payment->id);
        $params = [
            'discount' => $this->discount,
            'amountPaid' => $this->amountPaid
        ];
        $this->amountOwed = PayService::calculateDebtStatus($this->payment->id, $params);

        $this->student = StudentService::getOne($this->payment->estudiante_id);

        $this->paidDue = $this->amountPaid + $this->amountOwed;
        $this->amountTotal = ($this->program->costo - $this->payment->convalidacion) - $this->discount;
        $this->debt = $this->amountTotal - $this->paidDue;
        $this->breadcrumbs = [
            ['title' => "Contabilidad", "url" => "program-payment.list"],
            ['title' => "Estudiantes", "url" => "program-payment.show", "id" => $this->student->id],
            ['title' => "Pagos", "url" => "pay.show"]
        ];
        $this->payment = $this->getPayment($type, $paymentId);
        $this->numberModulesInProgress = ModuleService::getNumberModulesInProgress($this->program->id);
    }

    private function getPayment($type, $paymentId)
    {
        if ($type == 'program') {
            return ProgramPaymentService::getOne($paymentId);
        } else {
            // return PayService::getOne($paymentId);
        }
    }

    private function getDiscount()
    {
        $discountType = DiscountTypeService::getOne($this->payment->descuento_id);
        if (!$discountType) {
            return 0;
        }
        $discount = $this->program->costo * $discountType->porcentaje / 100;
        return $discount;
    }

    public function delete($id)
    {
        PayService::delete($id);
        $params = [
            'discount' => $this->discount,
            'amountPaid' => $this->amountPaid
        ];
        $this->amountOwed = PayService::calculateDebtStatus($this->payment->id, $params);
        return redirect()->route('pay.show', ['program', $this->payment->id]);
    }


    public function render()
    {
        $payments = PayService::getAllPaginateByProgramPayment($this->payment->id, 10);
        $payments->map(function ($payment) {
            $payment->acumulado = PayService::getMountByProgramPayment($this->payment->id, $payment->id);
            return $payment;
        });
        // dd($payments);
        return view('livewire.accounting.pay.show-pay', compact('payments'));
    }
}
