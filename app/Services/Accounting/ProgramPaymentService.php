<?php

namespace App\Services\Accounting;

use App\Constants\PaymentStatus;
use App\Models\ProgramPayment;
use App\Models\Student;
use App\Services\Academic\ProgramService;

class ProgramPaymentService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $program_payment = ProgramPayment::all();
        return $program_payment;
    }

    static public function getAllStudentPaginate($attribute, $paginate)
    {
        $program_payment = Student::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('honorifico', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('nombre', 'desc')
            ->paginate($paginate);
        return $program_payment;
    }

    static public function getAllStudentPaginateDebt($attribute, $paginate)
    {
        $program_payment = Student::where('tiene_deuda', true)
            ->where(function ($query) use ($attribute) {
                $query->where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
                    ->orWhere('apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
                    ->orWhere('cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
                    ->orWhere('honorifico', 'ILIKE', '%' . strtolower($attribute) . '%');
            })
            ->orderBy('nombre', 'desc')
            ->paginate($paginate);
        return $program_payment;
    }

    public static function getAllByStudent($student)
    {
        $program_payment = ProgramPayment::join('program', 'program.id', '=', 'program_payments.programa_id')
            ->join('student', 'student.id', '=', 'program_payments.estudiante_id')
            ->select('program_payments.estado as estado', 'program_payments.id as program_payment_id', 'program.*', 'student.nombre as estudiante')
            ->where('estudiante_id', $student)
            ->paginate(15);
        return $program_payment;
    }

    public static function getAllStudentsByProgram($program)
    {
        $program_payment = ProgramPayment::join('program', 'program.id', '=', 'program_payments.programa_id')
            ->join('student', 'student.id', '=', 'program_payments.estudiante_id')
            ->select('program_payments.estado as estado', 'program_payments.id as program_payment_id', 'program.id as ProgramId', 'student.*')
            ->where('programa_id', $program)
            ->paginate(10);
        return $program_payment;
    }


    public static function getAllByStudentWithPrograms()
    {
        $program_payment = ProgramPayment::join('program', 'program.id', '=', 'program_payments.programa_id')
            ->join('student', 'student.id', '=', 'program_payments.estudiante_id')
            ->selectRaw(
                'student.honorifico as honorifico,student.nombre as nombre, student.apellido as apellido,student.cedula as cedula, student.expedicion as expedicion,student.telefono as telefono,student.correo as correo,student.tiene_deuda as tiene_deuda, STRING_AGG(program.sigla, CHR(10)) as programas_con_deuda, COUNT(program_payments.id) as total_deudas'
            )
            ->where('program_payments.estado', 'CON DEUDA')
            ->groupBy('student.id', 'student.honorifico', 'student.nombre', 'student.apellido', 'student.cedula', 'student.expedicion', 'student.telefono', 'student.correo', 'student.tiene_deuda')
            ->get();

        return $program_payment;
    }

    static public function checkDebt($paymentId)
    {
        $payment = self::getOne($paymentId);
        $program = ProgramService::getOne($payment->programa_id);
        $student = Student::find($payment->estudiante_id);

        $discount = PayService::getDiscount($payment->tipo_descuento_id, $program->costo);
        $amountPaid = PayService::getAmountPaid($payment->id);
        $params = [
            'discount' => $discount,
            'amountPaid' => $amountPaid
        ];
        $amountOwed = PayService::calculateDebtStatus($payment->id, $params);
        $paidDue = $amountPaid + $amountOwed;
        $amountTotal = ($program->costo - $payment->convalidacion) - $discount;
        $debt = $amountTotal - $paidDue;
        $response =  [
            'discount' => $discount,
            'amountPaid' => $amountPaid,
            'amountOwed' => $amountOwed,
            'paidDue' => $paidDue,
            'amountTotal' => $amountTotal,
            'debt' => $debt
        ];
        if ($amountOwed > 0) {
            $payment->estado = PaymentStatus::WITHDEBT;
            $student->tiene_deuda = true;
            $student->save();
        } else {
            $payment->estado = PaymentStatus::NODEBT;
        }
        if ($debt == 0) {
            $payment->estado = PaymentStatus::PAID;
        }
        $payment->save();
        return $response;
    }

    static public function hasDebt($id)
    {
        $student = ProgramPayment::where('estudiante_id', $id)
            ->where('estado', PaymentStatus::WITHDEBT)
            ->first();
        return $student ? true : false;
    }

    static  public function getOne($id)
    {
        $program_payment = ProgramPayment::find($id);
        return $program_payment;
    }

    static public function create($data)
    {
        try {
            $new = ProgramPayment::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $program_payment = ProgramPayment::find($data['id']);
            $program_payment->update($data);
            $program_payment->save();
            return $program_payment;
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $program_payment = ProgramPayment::find($id);
            $program_payment->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
