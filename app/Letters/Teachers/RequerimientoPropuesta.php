<?php

namespace App\Letters\Teachers;

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

class RequerimientoPropuesta extends FpdfGlobal implements LetterDownloadInterface
{
    public function download($letterId)
    {
        $this->fpdf = new Fpdf('P', 'mm', 'letter');
        $this->fpdf->header('Content-type: application/pdf');
        $this->fpdf->header('Content-Disposition: inline; filename="Termino-Referencia.pdf"');

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

        $letterLeaders = LetterLeader::where('letter_id', $letterId)->first();
        if (!$letterLeaders) return false;
        $leader = Leader::find($letterLeaders->leader_id);
        $fullnameLeader = $this->getFullNameLeader($leader) ?? "No asignado";

        // parameters
        $title = $this->utf8_decode("REF.- REQUERIMIENTO DE PROPUESTA");

        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(25, $this->margin, 20);
        $this->fpdf->SetAutoPageBreak(true, 20);

        // HEADER
        $this->fpdf->Ln(15);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("Santa Cruz de la sierra, " . $literalDate), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("OF. COORD. ACAD. N° " . $letter->codigo_administrativo), 0, 'L', 0);

        $this->fpdf->Ln(4);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Señor. - "), 0, 'L', 0);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode($nameTeacher), 0, 'L', 0);     //dinamico
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("CONSULTOR."), 0, 'L', 0);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Presente. -"), 0, 'L', 0);

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $title, 0, 'L', 0);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode($nameTeacherShort), 0, 'L', 0);
        $this->fpdf->Ln(5);

        $contenido = [
            $this->utf8_decode("Tengo a bien remitir a su persona el requerimiento de propuesta en calidad de consultor en el <MÓDULO> denominado: \"" . $module->nombre . "\"," . $programType . "en " . $programName . ". a realizarse en fecha <" . $this->dateFormat($module->fecha_inicio) . " a " . $this->dateFormat($module->fecha_final) . "> . Teniendo una carga horaria de " . $hrsAcademic . " horas Académicas, el programa antes mencionado depende de la coordinación académica."),
            $this->utf8_decode("En caso de estar interesado, por favor hacer llegar el <CURRÍCULUM VITAE, CÉDULA DE IDENTIDAD, PROGRAMA DE ASIGNATURA (PROPUESTA)> y dar la conformidad de aceptación por escrito hasta el " . $this->literalDate($parametros["date"]) . "."),
        ];
        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($contenido[0]);
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($contenido[1]);
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, "Sin otro particular, saludo a usted atentamente.", 0, 'L', 0);
        $this->fpdf->Ln(70);
        // FONT BOLD
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _"), 0, 'C', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode($fullnameLeader), 0, 'C', 0);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("Coordinador Académico"), 0, 'C', 0);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("ESCUELA DE INGENIERÍA"), 0, 'C', 0);

        $this->fpdf->Output("I", "Activos-Fijos.pdf", true);
        exit;
    }
}
