<?php

namespace App\Livewire\Accounting\ProgramPayment;

use App\Services\Accounting\DiscountTypeService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;

class EditProgramPayment extends Component
{
    public $payment;
    public $discounts;

    public $paymentArray;

    public function mount($payment)
    {
        $this->payment = ProgramPaymentService::getOne($payment);
        $this->discounts = DiscountTypeService::getAll();
        $this->paymentArray = [
            'id' => $this->payment->id,
            'convalidacion' => $this->payment->convalidacion,
            'tipo_descuento_id' => $this->payment->tipo_descuento_id,
        ];
    }

    public function save()
    {
        $this->validate([
            'paymentArray.convalidacion' => 'nullable|numeric',
            'paymentArray.tipo_descuento_id' => 'nullable|numeric',
        ]);
        if ($this->paymentArray['tipo_descuento_id'] == '') {
            $this->paymentArray['tipo_descuento_id'] = null;
        }
        ProgramPaymentService::update($this->paymentArray);
        return redirect()->route('pay.show', ['program', $this->payment->id]);
    }

    public function render()
    {
        return view('livewire.accounting.program-payment.edit-program-payment');
    }
}
