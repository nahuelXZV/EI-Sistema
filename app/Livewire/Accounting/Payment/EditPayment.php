<?php

namespace App\Livewire\Accounting\Payment;

use App\Services\Accounting\CoursePaymentService;
use App\Services\Accounting\DiscountTypeService;
use App\Services\Accounting\ProgramPaymentService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPayment extends Component
{
    use WithFileUploads;
    public $breadcrumbs;
    public $payment;
    public $discounts;

    public $discountName;
    public $paymentArray;
    public $voucher;
    public $type;

    public function mount($type, $payment)
    {
        $this->payment = $this->getPayment($type, $payment);
        $this->discounts = DiscountTypeService::getAll();
        $this->paymentArray = [
            'id' => $this->payment->id,
            'convalidacion' => $this->payment->convalidacion,
            'comprobante' => $this->payment->comprobante,
            'tipo_descuento_id' => $this->payment->tipo_descuento_id,
        ];
        $this->type = $type;
        $this->discountName = $this->payment->tipo_descuento_id ? $this->discounts->firstWhere('id', $this->payment->tipo_descuento_id)->nombre : 'S/N';
        $this->breadcrumbs = [
            ['title' => "Contabilidad", "url" => "payment.list"],
            ['title' => "Estudiantes", "url" => "payment.show", "id" =>  $this->payment->estudiante_id],
            ['title' => "Pagos", "url" => "pay.show", "id" => [$this->type, $this->payment->id]],
            ['title' => "Editar Pago", "url" => "payment.edit", [$this->type, $this->payment->id]]
        ];
    }

    private function getPayment($type, $paymentId)
    {
        if ($type == 'program') {
            return ProgramPaymentService::getOne($paymentId);
        } else {
            return CoursePaymentService::getOne($paymentId);
        }
    }

    public function save()
    {
        if ($this->paymentArray['tipo_descuento_id'] == '') {
            $this->paymentArray['tipo_descuento_id'] = null;
        }
        if ($this->voucher != null) {
            $this->paymentArray['comprobante'] = $this->saveFile($this->voucher, $this->type . '/vouchers');
        }
        if ($this->type == 'program') {
            ProgramPaymentService::update($this->paymentArray);
        } else {
            CoursePaymentService::update($this->paymentArray);
        }
        return redirect()->route('pay.show', [$this->type, $this->payment->id]);
    }

    public function removeDiscount()
    {
        $this->paymentArray['tipo_descuento_id'] = null;
        $this->discountName = 'S/N';
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire.accounting.payment.edit-payment');
    }
}
