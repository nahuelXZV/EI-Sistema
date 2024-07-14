<?php

namespace App\Livewire\Accounting\Pay;

use App\Services\Accounting\CoursePaymentService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPay extends Component
{
    use WithPagination;
    public $breadcrumbs;
    public $payment;
    public $type;

    public function mount($type, $paymentId)
    {
        $this->payment = $this->getPayment($type, $paymentId);
        $this->breadcrumbs = [
            ['title' => "Contabilidad", "url" => "payment.list"],
            ['title' => "Estudiantes", "url" => "payment.show", "id" => $this->payment->estudiante_id],
            ['title' => "Pagos", "url" => "pay.show"]
        ];
        $this->type = $type;
    }

    public function getPayment($type, $paymentId)
    {
        if ($type == 'program') {
            return ProgramPaymentService::getOne($paymentId);
        } else {
            return CoursePaymentService::getOne($paymentId);
        }
    }

    public function render()
    {
        return view('livewire.accounting.pay.show-pay');
    }
}
