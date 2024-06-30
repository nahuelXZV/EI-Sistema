<?php

namespace App\Livewire\Accounting\ProgramPayment;

use App\Services\Accounting\DiscountTypeService;
use App\Services\Accounting\ProgramPaymentService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProgramPayment extends Component
{
    use WithFileUploads;
    public $breadcrumbs;
    public $payment;
    public $discounts;

    public $paymentArray;
    public $voucher;

    public function mount($payment)
    {
        $this->payment = ProgramPaymentService::getOne($payment);
        $this->discounts = DiscountTypeService::getAll();
        $this->paymentArray = [
            'id' => $this->payment->id,
            'convalidacion' => $this->payment->convalidacion,
            'comprobante' => $this->payment->comprobante,
            'tipo_descuento_id' => $this->payment->tipo_descuento_id,
        ];
        $this->breadcrumbs = [
            ['title' => "Contabilidad", "url" => "program-payment.list"],
            ['title' => "Estudiantes", "url" => "program-payment.show", "id" =>  $this->payment->estudiante_id],
            ['title' => "Pagos", "url" => "pay.show", "id" => ["program", $this->payment->id]],
            ['title' => "Editar Pago", "url" => "program-payment.edit", "id" => $this->payment->id]
        ];
    }

    public function save()
    {
        if ($this->paymentArray['tipo_descuento_id'] == '') {
            $this->paymentArray['tipo_descuento_id'] = null;
        }
        if ($this->voucher != null) {
            $this->paymentArray['comprobante'] = $this->saveFile($this->voucher, 'program/vouchers');
        }
        ProgramPaymentService::update($this->paymentArray);
        return redirect()->route('pay.show', ['program', $this->payment->id]);
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire.accounting.program-payment.edit-program-payment');
    }
}
