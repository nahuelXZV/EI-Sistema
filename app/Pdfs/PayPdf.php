<?php

namespace App\Pdfs;

use App\Models\Program;
use App\Services\Academic\ProgramService;
use App\Services\Academic\StudentService;
use App\Services\Accounting\CoursePaymentService;
use App\Services\Accounting\PayService;
use App\Services\Accounting\ProgramPaymentService;
use Codedge\Fpdf\Fpdf\Fpdf;

class PayPdf extends Fpdf
{
    protected $fpdf;

    public function generate($type, $paymentId)
    {
        $fpdf = new Fpdf('P', 'mm', 'letter');
        $fpdf->header('Content-type: application/pdf');
        $fpdf->header('Content-Disposition: inline; filename="Reporte-de-pagos.pdf"');

        if ($type === "program") {
            $payment = ProgramPaymentService::getOne($paymentId);
            $program = ProgramService::getOne($payment->programa_id);
            $dataDebt = ProgramPaymentService::checkDebt($payment->id);
            $payments = PayService::getAllByProgramPayment($payment->id);
        } else {
            $payment = CoursePaymentService::getOne($paymentId);
            $course = CoursePaymentService::getOne($payment->curso_id);
            $dataDebt = CoursePaymentService::checkDebt($payment->id);
            $payments = PayService::getAllByCoursePayment($payment->id);
        }

        $student = StudentService::getOne($payment->estudiante_id);
        $studentName = $student->honorifico . ' ' . $student->nombre . ' ' . $student->apellido;

        $discount = $dataDebt['discount'];
        $amountTotal = $dataDebt['amountTotal'];
        $amountPaid = $dataDebt['amountPaid'];
        $debt = $dataDebt['debt'];
        $amountOwed = $dataDebt['amountOwed'];

        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Image(public_path() . '/imgs/logo2.jpg', 10, 10, 45, 0, 'JPG');
        $fpdf->Cell(188, 6, 'UNIVERSIDAD AUTONOMA GABRIEL RENE MORENO', 0, 1, 'C');
        $fpdf->Cell(188, 6, 'FACULTAD DE CIENCIAS EXACTA Y TEGNOLOGIA', 0, 1, 'C');
        $fpdf->Cell(188, 6, 'ESCUELA DE INGENIERIA', 0, 1, 'C');
        $fpdf->Ln();

        //cuerpo del reporte
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(188, 10, 'REPORTE DE PAGOS POR MAESTRANTE', 1, 1, 'C');
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(80, 6, 'NOMBRE DEL MAESTRANTE:', 1, 0);
        $fpdf->Cell(108, 6, utf8_decode($studentName), 1, 1);
        $fpdf->Cell(80, 6, 'ESTADO:', 1, 0);
        $fpdf->Cell(108, 6, $payment->estado, 1, 1);

        if ($type == "program") {
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(188, 10, 'DATOS DEL PROGRAMA', 0, 1, 'C');
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(80, 6, 'NOMBRE DEL PROGRAMA:', 1, 0);
            $fpdf->MultiCell(108, 6, utf8_decode($program->nombre), 1, 1);
            $fpdf->Cell(80, 6, 'VERSION:', 1, 0);
            $fpdf->Cell(108, 6, $program->version, 1, 1);
            $fpdf->Cell(80, 6, 'EDICION:', 1, 0);
            $fpdf->Cell(108, 6, $program->edicion, 1, 1);
            $fpdf->Cell(80, 6, 'FECHA DE INICIO:', 1, 0);
            $fpdf->Cell(108, 6, \Carbon\Carbon::parse($program->fecha_inicio)->format('d-m-Y'), 1, 1);
            $fpdf->Cell(80, 6, 'FECHA DE FINALIZACION:', 1, 0);
            $fpdf->Cell(108, 6, \Carbon\Carbon::parse($program->fecha_final)->format('d-m-Y'), 1, 1);
            $fpdf->Cell(80, 6, 'CANTIDAD DE MODULO:', 1, 0);
            $fpdf->Cell(108, 6, $program->cantidad_modulos, 1, 1);
            $fpdf->Cell(80, 6, 'COSTO TOTAL DEL PROGRAMA:', 1, 0);
            $fpdf->Cell(108, 6, $program->costo, 1, 1);
            $fpdf->Cell(80, 6, 'CONVALIDACION:', 1, 0);
            $fpdf->Cell(108, 6, $payment->convalidacion ?? 0, 1, 1);
            $fpdf->Cell(80, 6, 'DESCUENTO:', 1, 0);
            $fpdf->Cell(108, 6, $discount, 1, 1);
            $fpdf->Cell(80, 6, 'COSTO TOTAL DEL PROGRAMA:', 1, 0);
            $fpdf->Cell(108, 6, $amountTotal, 1, 1);
            $fpdf->SetFont('Arial', 'B', 10);

            //DATOS ECONOMICOS
            $fpdf->Cell(188, 10, 'DATOS ECONOMICOS', 0, 1, 'C');
            $fpdf->SetFont('Arial', '', 8);
            $fpdf->Cell(37, 6, 'MONTO PAGADO', 1, 0);
            $fpdf->Cell(55, 6, 'MONTO ADEUDADO HASTA LA FECHA', 1, 0);
            $fpdf->Cell(50, 6, 'MONTO PAGADO HASTA LA FECHA', 1, 0);
            $fpdf->Cell(46, 6, 'SALDO TOTAL DEL PROGRAMA', 1, 1);
            $fpdf->Cell(37, 6, $amountPaid, 1, 0);
            $fpdf->Cell(55, 6, $amountOwed, 1, 0);
            $fpdf->Cell(50, 6, $amountPaid, 1, 0);
            $fpdf->Cell(46, 6, $debt, 1, 1);
        } else {
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(188, 10, 'DATOS DEL CURSO', 0, 1, 'C');
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(80, 6, 'NOMBRE DEL CURSO:', 1, 0);
            $fpdf->MultiCell(108, 6, utf8_decode($course->nombre), 1, 1);
            $fpdf->Cell(80, 6, 'MODALIDAD DEL CURSO:', 1, 0);
            $fpdf->MultiCell(108, 6, utf8_decode($course->modalidad), 1, 1);
            $fpdf->Cell(80, 6, 'FECHA DE INICIO:', 1, 0);
            $fpdf->Cell(108, 6, \Carbon\Carbon::parse($course->fecha_inicio)->format('d-m-Y'), 1, 1);
            $fpdf->Cell(80, 6, 'FECHA DE FINALIZACION:', 1, 0);
            $fpdf->Cell(108, 6, \Carbon\Carbon::parse($course->fecha_final)->format('d-m-Y'), 1, 1);
            $fpdf->Cell(80, 6, 'COSTO TOTAL DEL CURSO:', 1, 0);
            $fpdf->Cell(108, 6, $course->costo, 1, 1);
            $fpdf->Cell(80, 6, 'CONVALIDACION:', 1, 0);
            $fpdf->Cell(108, 6, $payment->convalidacion ?? 0, 1, 1);
            $fpdf->Cell(80, 6, 'DESCUENTO:', 1, 0);
            $fpdf->Cell(108, 6, $discount, 1, 1);
            $fpdf->Cell(80, 6, 'COSTO TOTAL DEL PROGRAMA:', 1, 0);
            $fpdf->Cell(108, 6, $amountTotal, 1, 1);
            $fpdf->SetFont('Arial', 'B', 10);

            //DATOS ECONOMICOS
            $fpdf->Cell(188, 10, 'DATOS ECONOMICOS', 0, 1, 'C');
            $fpdf->SetFont('Arial', '', 8);
            $fpdf->Cell(64, 6, 'MONTO A PAGAR', 1, 0);
            $fpdf->Cell(62, 6, 'MONTO PAGADO HASTA LA FECHA', 1, 0);
            $fpdf->Cell(62, 6, 'SALDO TOTAL DEL PROGRAMA', 1, 1);
            $fpdf->Cell(64, 6, $amountTotal, 1, 0);
            $fpdf->Cell(62, 6, $amountPaid, 1, 0);
            $fpdf->Cell(62, 6, $debt, 1, 1);
        }


        //DETALLES DE LOS PAGOS
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(188, 10, 'DETALLES DE LOS PAGOS', 0, 1, 'C');
        $fpdf->SetFont('Arial', '', 8);
        $i = 1;
        $fpdf->Cell(10, 6, 'Nro.', 1, 0);
        $fpdf->Cell(59, 6, 'METODO DE PAGO.', 1, 0);
        $fpdf->Cell(60, 6, 'FECHA DE PAGO.', 1, 0);
        $fpdf->Cell(60, 6, 'MONTO PAGADO.', 1, 1);

        //rellenado de los pagos
        $pagado = 0;
        $i = 1;
        foreach ($payments as $pay) {
            $fpdf->Cell(10, 6, $i, 1, 0);
            $fpdf->Cell(59, 6, utf8_decode($pay->tipo_pago), 1, 0);
            $fpdf->Cell(60, 6, \Carbon\Carbon::parse($pay->fecha)->format('d/m/Y'), 1, 0);
            $fpdf->Cell(60, 6, $pay->monto, 1, 1);
            $pagado = $pagado + $pay->monto;
            $i = $i + 1;
        }
        $fpdf->Cell(69, 6, '', 0, 0);
        $fpdf->Cell(60, 6, 'TOTAL PAGADO.', 1, 0);
        $fpdf->Cell(60, 6, $pagado, 1, 1);
        $fpdf->Output("I", "Reporte-de-pagos.pdf", true);
        exit;
    }
}
