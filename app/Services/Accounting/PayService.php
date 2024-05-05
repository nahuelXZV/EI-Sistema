<?php

namespace App\Services\Accounting;

use App\Models\Pay;
use App\Models\PaymentType;
use App\Services\Academic\ModuleInscriptionService;
use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramService;

class PayService
{
    public function __construct()
    {
    }

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

    static public function getAllPaginateByProgramPayment($program_paymentId, $paginate, $order = "desc")
    {
        $payments = Pay::where('programa_pago_id', $program_paymentId)
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $payments;
    }

    static public function getMountByProgramPayment($program_paymentId, $payId)
    {
        $mount = Pay::where('programa_pago_id', $program_paymentId)->where('id', '<=', $payId)->sum('monto');
        return $mount;
    }

    static public function getAmountPaid($program_paymentId)
    {
        $amountPaid = Pay::where('programa_pago_id', $program_paymentId)->sum('monto');
        return $amountPaid;
    }
    /*         $programa = Programa::find($pago_estudiante->programa_id);
        $descuento  = $programa->costo * $pago_estudiante->tipo_descuento->monto / 100;
        $monto_total_programa = ($programa->costo - $pago_estudiante->convalidacion) - $descuento;
        $monto_pagado = Pago::where('pago_estudiante_id', $pago_estudiante->id)->sum('monto');
        $cantidad_modulos = $programa->cantidad_modulos;
        $precio_modulo = $monto_total_programa / $cantidad_modulos;
        // $cantidad_modulo_inscritos = EstudianteModulo::where('id_estudiante', $pago_estudiante->estudiante_id)->where('programa_id', $pago_estudiante->programa_id)->count();
        $cantidad_modulo_inscritos = EstudianteModulo::Join('modulos', 'estudiante_modulos.id_modulo', '=', 'modulos.id')
            ->where('estudiante_modulos.id_estudiante', $pago_estudiante->estudiante_id)
            ->where('modulos.programa_id', $pago_estudiante->programa_id)
            ->count();

        if ($monto_pagado < ($cantidad_modulo_inscritos * $precio_modulo)) {
            $monto_adeudado = ($cantidad_modulo_inscritos * $precio_modulo) - $monto_pagado;
        } else {
            $monto_adeudado = 0;
        }
        if ($monto_adeudado > 0) {
            $pago_estudiante->estado = 'CON DEUDA';
        } else {
            $pago_estudiante->estado = 'SIN DEUDA';
        }
        $pago_estudiante->save();
        return $monto_adeudado; */
    static public function calculateDebtStatus($program_paymentId, $params)
    {
        $program_payment = ProgramPaymentService::getOne($program_paymentId);
        $program = ProgramService::getOne($program_payment->programa_id);
        $discount = $params['discount'];
        $amountTotal = ($program->costo - $program_payment->convalidacion) - $discount;
        $amountPaid = $params['amountPaid'];
        $numberModules = $program->cantidad_modulos;
        $priceModule = $amountTotal / $numberModules;
        $numberModuleEnrolled = ModuleInscriptionService::getCountModuleEnrolled($program_payment->estudiante_id, $program_payment->programa_id);
        if ($amountPaid < ($numberModuleEnrolled * $priceModule)) {
            $amountOwed = ($numberModuleEnrolled * $priceModule) - $amountPaid;
        } else {
            $amountOwed = 0;
        }
        if ($amountOwed > 0) {
            $program_payment->estado = 'CON DEUDA';
        } else {
            $program_payment->estado = 'SIN DEUDA';
        }
        $program_payment->save();
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
};
