<?php

namespace App\Services\Accounting;

use App\Constants\PaymentStatus;
use App\Models\CoursePayment;
use App\Services\Academic\CourseService;

class CoursePaymentService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $course_payments = CoursePayment::all();
        return $course_payments;
    }

    public static function getAllByStudent($student)
    {
        $course_payment = CoursePayment::join('course', 'course.id', '=', 'course_payments.curso_id')
            ->join('student', 'student.id', '=', 'course_payments.estudiante_id')
            ->select('course_payments.estado as estadoPayment', 'course_payments.id as course_payment_id', 'course.*', 'student.nombre as estudiante')
            ->where('estudiante_id', $student)
            ->paginate(15, pageName: "coursesPage");
        return $course_payment;
    }

    public static function getAllStudentsByCourse($course)
    {
        $course_payment = CoursePayment::join('course', 'course.id', '=', 'course_payments.curso_id')
            ->join('student', 'student.id', '=', 'course_payments.estudiante_id')
            ->select('course_payments.estado as estadoPayment', 'course_payments.id as course_payment_id', 'course.id as courseId', 'student.*')
            ->where('curso_id', $course)
            ->paginate(10);
        return $course_payment;
    }


    static public function checkDebt($paymentId, $updateState = false)
    {
        $payment = self::getOne($paymentId);
        $course = CourseService::getOne($payment->curso_id);

        $discount = PayService::getDiscount($payment->tipo_descuento_id, $course->costo);
        $amountTotal = ($course->costo - $payment->convalidacion) - $discount;
        $amountPaid = PayService::getAmountPaidByCourse($paymentId);
        $debt = $amountTotal - $amountPaid;
        $response =  [
            'discount' => $discount,
            'amountTotal' => $amountTotal,
            'amountPaid' => $amountPaid,
            'debt' => $debt,
            'amountOwed' => 0,
            'paidDue' => 0
        ];
        if (!$updateState) return $response;
        if ($debt == 0) {
            $payment->estado = PaymentStatus::PAID;
        } else {
            $payment->estado = PaymentStatus::WITHDEBT;
        }
        $payment->save();
        return $response;
    }

    static public function hasDebt($id)
    {
        $student = CoursePayment::where('estudiante_id', $id)
            ->where('estado', PaymentStatus::WITHDEBT)
            ->first();
        return $student ? true : false;
    }

    static  public function getOne($id)
    {
        $course_payment = CoursePayment::find($id);
        return $course_payment;
    }

    static public function create($data)
    {
        try {
            $new = CoursePayment::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $course_payment = CoursePayment::find($data['id']);
            $course_payment->update($data);
            $course_payment->save();
            return $course_payment;
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $course_payment = CoursePayment::find($id);
            $course_payment->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
