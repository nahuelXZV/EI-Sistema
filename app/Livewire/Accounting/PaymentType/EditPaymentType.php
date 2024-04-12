<?php

namespace App\Livewire\Accounting\PaymentType;

use App\Services\Accounting\PaymentTypeService;
use Livewire\Component;

class EditPaymentType extends Component
{
    public $breadcrumbs = [['title' => "Tipos de Pago", "url" => "payment-type.list"], ['title' => "Editar", "url" => "payment-type.edit"]];
    public $paymentTypeArray = [];

    public $validate = [
        'paymentTypeArray.nombre' => 'required',
    ];

    public $message = [
        'paymentTypeArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount($payment_type)
    {
        $paymentTypeEntity = PaymentTypeService::getOne($payment_type);
        $this->paymentTypeArray = [
            'id' => $paymentTypeEntity->id,
            'nombre' => $paymentTypeEntity->nombre,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        PaymentTypeService::update($this->paymentTypeArray);
        return redirect()->route('payment-type.list');
    }

    public function render()
    {
        return view('livewire..accounting.payment-type.edit-payment-type');
    }
}
