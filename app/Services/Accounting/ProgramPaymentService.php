<?php

namespace App\Services\Accounting;

use App\Models\ProgramPayment;
use App\Models\Student;

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

    static public function getAllStudentPaginate($attribute, $paginate, $hasDebt)
    {
        $program_payment = Student::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('honorifico', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('nombre', 'desc')
            ->paginate($paginate);
        if ($hasDebt) {
            $program_payment = $program_payment->filter(function ($item) {
                return $item->tiene_deuda == true;
            });
        }
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
            return $program_payment;
        } catch (\Throwable $th) {
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
