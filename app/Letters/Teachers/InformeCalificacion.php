<?php

namespace App\Letters\Teachers;

use App\Constants\Position;
use App\Interfaces\LetterDownloadInterface;
use App\Letters\FpdfGlobal;
use App\Models\Leader;
use App\Models\LetterLeader;
use App\Services\Academic\ContractService;
use App\Services\Academic\LetterService;
use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramService;
use App\Services\Academic\TeacherService;
use Codedge\Fpdf\Fpdf\Fpdf;

class InformeCalificacion extends FpdfGlobal implements LetterDownloadInterface
{
    public function download($letterId)
    {
        $this->fpdf = new Fpdf('P', 'mm', 'letter');
        $this->fpdf->header('Content-type: application/pdf');
        $this->fpdf->header('Content-Disposition: inline; filename="Informe-Calificacion.pdf"');

        // data
        $letter = LetterService::getOne($letterId);
        if (!$letter) return false;
        $parametros = json_decode($letter->parametros, true);
        $contract = ContractService::getOne($letter->contrato_id);
        $module = ModuleService::getOne($contract->modulo_id);
        $program = ProgramService::getOne($module->programa_id);
        $teacher = TeacherService::getOne($contract->docente_id);
        $literalDate = $this->literalDate($letter->fecha_carta);
        $nameTeacher = $this->getFullNameTeacher($contract->docente_id);
        $lastName = explode(" ", $teacher->apellido);
        $firstLastName = $lastName[0];
        $nameTeacherShort = $teacher->honorifico . " " .  $firstLastName;

        $programName = $this->getNameProgram($program);
        $programType = $this->getTypeProgram($program->tipo);
        $hrsAcademic  = $module->hrs_academicas . " (" . $this->literalNumber($module->hrs_academicas) . ")";
        $literalDate = $this->literalDate($letter->fecha_carta);

        $letterLeaders = LetterLeader::where('letter_id', $letterId)->get();
        if (!$letterLeaders) return false;
        $nameCoordinador = "No asignado";
        $nameEncargado = "No asignado";
        $nameResponsable = "No asignado";
        foreach ($letterLeaders as $key => $leader) {
            $leader = Leader::find($leader->leader_id);
            if ($leader->cargo == Position::COORDINADORACADEMICO) {
                $nameCoordinador = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::ENCARGADOPLAFORMAVIRTUAL) {
                $nameEncargado = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::RESPONSABLECONTRATACIONJAF) {
                $nameResponsable = $this->getFullNameLeader($leader);
            }
        }
        $partes = explode(" ", $nameResponsable);
        $nameResponsableShort  = $partes[0] . " " . $partes[1] . " " . $partes[2];

        // parameters
        $title = $this->utf8_decode("INFORME DE CALIFICACION");

        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(25, $this->margin, 20);
        $this->fpdf->SetAutoPageBreak(true, 20);

        // HEADERs
        $this->fpdf->Ln(15);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $title, 0, 'C', 0);
        $this->fpdf->Ln(5);

        $this->widths = array(14, $this->width - 14);
        $this->RowHeader(array($this->utf8_decode('DE:'), $this->utf8_decode($nameCoordinador . " - Coordinador Académico E.I. - F.C.E.T. \n" . $nameEncargado . " - Encargado de Plataforma Virtual E.I. - F.E.C.T.")));
        $this->RowHeader(array($this->utf8_decode('A:'), $this->utf8_decode($nameResponsable . " - Responsable de Procesos de Contratación - JAF.  ")));
        $this->fpdf->Ln(5);


        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Distinguido " . $nameResponsableShort), 0, 'L', 0);
        $this->fpdf->Ln(3);

        $contenido = [
            $this->utf8_decode("En cumplimiento a las normas establecidas, informo a usted que el proceso de calificación para la contratación del consultor por producto para el <MÓDULO> denominado: \"" . $module->nombre . "\", correspondiente " . $programType . "en " . $programName . ". Se concluyó con el proceso bajo el siguiente detalle: "),
            $this->utf8_decode("Por todo lo expuesto anteriormente expreso la conformidad respecto a la recepción de todos los temas arriba citados e informar que <CUMPLE> con los requerido por la capacitación según los términos de referencia; así también se <RECOMIENDA LA ADJUDICACION>."),
        ];

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($contenido[0]);
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(3);

        $propuesta = [
            $this->utf8_decode("Solicitud de contratación para consultor e informe presupuestario mediante comunicación OF.COORD. ACAD. N.º " . $parametros['codigo'] . "."),
            $this->utf8_decode("CONSULTOR	: " . $nameTeacher),
            $this->utf8_decode("CEDULA DE IDENTIDAD: " . $teacher->cedula . " " . $teacher->expedicion),
            $this->utf8_decode("PROGRAMAS 	:  " . $program->tipo . " en " . $programName . "."),
            $this->utf8_decode("MODULO   : \"" . $module->nombre . "\"."),
            $this->utf8_decode("HONORARIO	: Bs. " . $contract->honorarios . " (Total Ganado)."),
            $this->utf8_decode("HORAS ACADEMICAS: " . $hrsAcademic),
            $this->utf8_decode("DURACION DEL MODULO: " . $this->dateFormat($parametros['fecha_inicio']) . " al " . $this->dateFormat($parametros['fecha_fin'])),
            $this->utf8_decode("HORARIOS   : " . $contract->horario),
        ];
        $this->fpdf->SetFont('Arial', '', 10);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[0]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[1]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[2]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[3]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[4]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[5]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[6]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[7]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[8]);
        $this->fpdf->Ln(5);

        $factura = $teacher->factura ? "SI" : "NO";

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("EL CONSULTOR " . $factura . " PRESENTA FACTURA."), 0, 'L', 0);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($contenido[1]);
        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, "Santa Cruz " . $this->literalDate($letter->fecha_carta), 0, 'L', 0);
        $this->fpdf->Ln(40);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($this->width / 2, $this->space, $this->utf8_decode("_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _"), 0, 0, 'C');
        $this->fpdf->Cell($this->width / 2, $this->space, $this->utf8_decode("_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _"), 0, 0, 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell($this->width / 2, $this->space, $this->utf8_decode($nameEncargado), 0, 0, 'C');
        $this->fpdf->Cell($this->width / 2, $this->space, $this->utf8_decode($nameCoordinador), 0, 0, 'C');
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->Cell($this->width / 2, $this->space, $this->utf8_decode("Encargado Plataforma Virtual"), 0, 0, 'C');
        $this->fpdf->Cell($this->width / 2, $this->space, $this->utf8_decode("Coordinador Académico"), 0, 0, 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell($this->width / 2, $this->space, $this->utf8_decode("ESCUELA DE INGENIERIA-F.C.E.T"), 0, 0, 'C');
        $this->fpdf->Cell($this->width / 2, $this->space, $this->utf8_decode("ESCUELA DE INGENIERIA-F.C.E.T"), 0, 0, 'C');

        $this->fpdf->Output("I", "Activos-Fijos.pdf", true);
        exit;
    }
}
