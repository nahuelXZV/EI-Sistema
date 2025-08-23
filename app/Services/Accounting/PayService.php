<?php

namespace App\Services\Accounting;

use App\Constants\PaymentStatus;
use App\Models\Pay;
use App\Models\PaymentType;
use App\Services\Academic\ModuleInscriptionService;
use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramService;

class PayService
{
    public function __construct() {}

    static public function getAll()
    {
        $pay = Pay::all();
        return $pay;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $payment_types = Pay::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $payment_types;
    }

    static public function getAllPaginateByProgramPayment($program_paymentId, $paginate, $order = "asc")
    {
        $payments = Pay::join('payment_type', 'pay.tipo_pago_id', '=', 'payment_type.id')
            ->select('pay.*', 'payment_type.nombre as tipo_pago')
            ->where('programa_pago_id', $program_paymentId)
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $payments;
    }

    static public function getAllPaginateByCoursePayment($course_paymentId, $paginate, $order = "asc")
    {
        $payments = Pay::join('payment_type', 'pay.tipo_pago_id', '=', 'payment_type.id')
            ->select('pay.*', 'payment_type.nombre as tipo_pago')
            ->where('curso_pago_id', $course_paymentId)
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $payments;
    }

    static public function getAllByProgramPayment($program_paymentId)
    {
        $mount = Pay::join('payment_type', 'pay.tipo_pago_id', '=', 'payment_type.id')
            ->select('pay.*', 'payment_type.nombre as tipo_pago')
            ->where('programa_pago_id', $program_paymentId)->get();
        return $mount;
    }

    static public function getAllByCoursePayment($course_paymentId)
    {
        $mount = Pay::join('payment_type', 'pay.tipo_pago_id', '=', 'payment_type.id')
            ->select('pay.*', 'payment_type.nombre as tipo_pago')
            ->where('curso_pago_id', $course_paymentId)->get();
        return $mount;
    }

    static public function getMountByProgramPayment($program_paymentId, $payId)
    {
        $mount = Pay::where('programa_pago_id', $program_paymentId)->where('id', '<=', $payId)->sum('monto');
        return $mount;
    }

    static public function getMountByCoursePayment($course_paymentId, $payId)
    {
        $mount = Pay::where('curso_pago_id', $course_paymentId)->where('id', '<=', $payId)->sum('monto');
        return $mount;
    }


    static public function getAmountPaid($program_paymentId)
    {
        $amountPaid = Pay::where('programa_pago_id', $program_paymentId)->sum('monto');
        return $amountPaid;
    }

    static public function getAmountPaidByCourse($curso_paymentId)
    {
        $amountPaid = Pay::where('curso_pago_id', $curso_paymentId)->sum('monto');
        return $amountPaid;
    }

    static public function calculateDebtStatus($program_paymentId, $params)
    {
        $program_payment = ProgramPaymentService::getOne($program_paymentId);
        $program = ProgramService::getOne($program_payment->programa_id);
        $discount = $params['discount'];
        $amountTotal = ($program->costo - $program_payment->convalidacion) - $discount;
        $amountPaid = $params['amountPaid'];
        $numberModules = $program->cantidad_modulos;
        if ($numberModules == 0) $numberModules = 1;
        $priceModule = $amountTotal / $numberModules;
        $numberModuleEnrolled = ModuleInscriptionService::getCountModuleEnrolled($program_payment->estudiante_id, $program_payment->programa_id);
        if ($amountPaid < ($numberModuleEnrolled * $priceModule)) {
            $amountOwed = ($numberModuleEnrolled * $priceModule) - $amountPaid;
        } else {
            $amountOwed = 0;
        }
        return $amountOwed;
    }

    static  public function getOne($id)
    {
        $pay = Pay::find($id);
        return $pay;
    }

    static public function create($data)
    {
        try {
            $new = Pay::create($data);
            return $new;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $pay = Pay::find($data['id']);
            $pay->update($data);
            return $pay;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $pay = Pay::find($id);
            $pay->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function getDiscount($discountId, $costo)
    {
        $discountType = DiscountTypeService::getOne($discountId);
        if (!$discountType) {
            return 0;
        }
        return $costo * $discountType->porcentaje / 100;
    }
};
