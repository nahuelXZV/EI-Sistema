<?php

namespace App\Livewire\Accounting\Pay;

use App\Services\Academic\StudentService;
use App\Services\Accounting\CoursePaymentService;
use App\Services\Accounting\PaymentTypeService;
use App\Services\Accounting\PayService;
use App\Services\Accounting\ProgramPaymentService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePay extends Component
{
    use WithFileUploads;
    public $breadcrumbs;

    public $student;
    public $program;
    public $payment;
    public $payArray;
    public $voucher;
    public $paymentTypes;
    public $type;

    public $validate = [
        'payArray.monto' => 'required|numeric',
        'payArray.fecha' => 'required',
        'payArray.hora' => 'required',
        'payArray.tipo_pago_id' => 'required',
        'voucher' => 'required'
    ];

    public $message = [
        'payArray.monto.required' => 'El monto es requerido',
        'payArray.monto.numeric' => 'El monto debe ser un número',
        'payArray.fecha.required' => 'La fecha es requerida',
        'payArray.hora.required' => 'La hora es requerida',
        'payArray.tipo_pago_id.required' => 'El tipo de pago es requerido',
        'voucher.required' => 'El comprobante es requerido'
    ];


    public function mount($type, $paymentId)
    {
        $this->payment = $this->getPayment($type, $paymentId);
        $this->student = StudentService::getOne($this->payment->estudiante_id);
        $this->paymentTypes = PaymentTypeService::getAll();
        $this->type = $type;
        $this->payArray = [
            "monto" => null,
            "fecha" => now()->format('Y-m-d'),
            "hora" => now()->format('H:i'),
            "comprobante" => null,
            "observacion" => null,
            "programa_pago_id" => null,
            "curso_pago_id" => null,
            "tipo_pago_id" => null
        ];
        if ($type == 'program') {
            $this->payArray['programa_pago_id'] = $this->payment->id;
        } else {
            $this->payArray['curso_pago_id'] = $this->payment->id;
        }
        $this->breadcrumbs = [
            ['title' => "Contabilidad", "url" => "payment.list"],
            ['title' => "Estudiantes", "url" => "payment.show", "id" => $this->student->id],
            ['title' => "Pagos", "url" => "pay.show", "id" => [$this->type, $this->payment->id]],
            ['title' => "Crear Pago", "url" => "pay.show", "id" => [$this->type, $this->payment->id]]
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
        $this->validate($this->validate, $this->message);
        $this->payArray['comprobante'] = $this->saveFile($this->voucher, 'vouchers');
        PayService::create($this->payArray);
        if ($this->type == 'course')
            CoursePaymentService::checkDebt($this->payment->id, true);
        if ($this->type == 'program')
            ProgramPaymentService::checkDebt($this->payment->id);
        return redirect()->route('pay.show', [$this->type, $this->payment->id]);
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire.accounting.pay.create-pay');
    }
}
