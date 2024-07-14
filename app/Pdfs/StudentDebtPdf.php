<?php

namespace App\Pdfs;

use App\Models\Student;
use App\Services\Accounting\ProgramPaymentService;
use Codedge\Fpdf\Fpdf\Fpdf;

class StudentDebtPdf extends Fpdf
{
    protected $fpdf;

    public function generate($debt)
    {
        $fpdf = new Fpdf('P', 'mm', 'letter');
        $fpdf->header('Content-type: application/pdf');
        $fpdf->header('Content-Disposition: inline; filename="Reporte-de-deudas.pdf"');

        if ($debt === "Deudores") {
            $students = ProgramPaymentService::getAllByStudentWithPrograms();
        } else {
            $students = Student::all();
        }


        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Image(public_path() . '/imgs/logo2.jpg', 10, 10, 45, 0, 'JPG');
        $fpdf->Cell(188, 6, 'UNIVERSIDAD AUTONOMA GABRIEL RENE MORENO', 0, 1, 'C');
        $fpdf->Cell(188, 6, 'FACULTAD DE CIENCIAS EXACTA Y TEGNOLOGIA', 0, 1, 'C');
        $fpdf->Cell(188, 6, 'ESCUELA DE INGENIERIA', 0, 1, 'C');
        $fpdf->Ln();
        //cuerpo del reporte

        //DATOS ECONOMICOS
        if ($debt === "Deudores") {
            $fpdf->Cell(188, 6, 'REPORTE DE ESTUDIANTES CON DEUDA', 0, 1, 'C');
        } else {
            $fpdf->Cell(188, 6, 'REPORTE DE ESTUDIANTES', 0, 1, 'C');
        }
        $fpdf->Ln();
        $fpdf->SetFont('Arial', 'B', 8);
        $fpdf->Cell(60, 6, 'NOMBRE COMPLETO', 1, 0);
        $fpdf->Cell(20, 6, 'CI', 1, 0);
        $fpdf->Cell(15, 6, 'TELF.', 1, 0);
        $fpdf->Cell(50, 6, 'CORREO', 1, 0);
        if ($debt === "Deudores") {
            $fpdf->Cell(28, 6, 'PROGRAMAS', 1, 1);
        } else {
            $fpdf->Cell(12, 6, 'DEUDA', 1, 1);
        }
        $fpdf->SetFont('Arial', '', 8);
        foreach ($students as $student) {
            $fpdf->Cell(60, 6, $student->nombre . ' ' . $student->apellido, 1, 0);
            $fpdf->Cell(20, 6, $student->cedula . ' ' . $student->expedicion, 1, 0);
            $fpdf->Cell(15, 6, $student->telefono, 1, 0);
            $fpdf->Cell(50, 6, $student->correo, 1, 0);
            if ($debt === "Deudores") {
                $fpdf->Cell(28, 6, $student->programas_con_deuda, 1, 1);
            } else {
                if ($student->tiene_deuda) {
                    $fpdf->Cell(12, 6, 'Si', 1, 1);
                } else {
                    $fpdf->Cell(12, 6, 'No', 1, 1);
                }
            }
        }

        $fpdf->Output("I", "Reporte-de-deudas.pdf", true);
        exit;
    }
}
