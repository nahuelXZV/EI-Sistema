<?php

namespace App\Livewire\Accounting\PaymentType;

use App\Services\Accounting\PaymentTypeService;
use Livewire\Component;

class CreatePaymentType extends Component
{
    public $breadcrumbs = [['title' => "Tipos de Pago", "url" => "payment-type.list"], ['title' => "Crear", "url" => "payment-type.new"]];
    public $paymentTypeArray = [];

    public $validate = [
        'paymentTypeArray.nombre' => 'required',
    ];

    public $message = [
        'paymentTypeArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount()
    {
        $this->paymentTypeArray = [
            'nombre' => '',
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        PaymentTypeService::create($this->paymentTypeArray);
        return redirect()->route('payment-type.list');
    }

    public function render()
    {
        return view('livewire..accounting.payment-type.create-payment-type');
    }
}
