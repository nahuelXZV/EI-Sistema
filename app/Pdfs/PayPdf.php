<?php

namespace App\Pdfs;

use App\Services\Academic\ProgramService;
use App\Services\Academic\StudentService;
use App\Services\Accounting\PayService;
use App\Services\Accounting\ProgramPaymentService;
use Codedge\Fpdf\Fpdf\Fpdf;

class PayPdf extends Fpdf
{
    protected $fpdf;

    public function generate($type, $paymentId)
    {
        $this->fpdf->header('Content-type: application/pdf');
        $this->fpdf->header('Content-Disposition: inline; filename="Reporte de Pagos.pdf"');
        $programPayment = ProgramPaymentService::getOne($paymentId);
        $student = StudentService::getOne($programPayment->estudiante_id);
        $program = ProgramService::getOne($programPayment->programa_id);

        $studentName = $student->honorifico . ' ' . $student->nombre . ' ' . $student->apellido;
        $discount = PayService::getDiscount($programPayment->descuento_id, $program->costo);
        $amountPaid = PayService::getAmountPaid($programPayment->id);
        $params = [
            'discount' => $discount,
            'amountPaid' => $amountPaid
        ];
        $amountOwed = PayService::calculateDebtStatus($programPayment->id, $params);
        $paidDue = $amountPaid + $amountOwed;
        $amountTotal = ($program->costo - $programPayment->convalidacion) - $discount;
        $debt = $amountTotal - $paidDue;

        $payments = PayService::getALlByProgramPayment($programPayment->id);

        $fpdf = new Fpdf('P', 'mm', 'letter');
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Image(public_path() . '\imgs\logo2.jpg', 10, 10, 45, 0, 'JPG');
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
        $fpdf->Cell(108, 6, $programPayment->estado, 1, 1);

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
        $fpdf->Cell(108, 6, $programPayment->convalidacion ?? 0, 1, 1);
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
        $fpdf->Output("I", "Reporte de Pagos.pdf");
        exit;
    }
}
