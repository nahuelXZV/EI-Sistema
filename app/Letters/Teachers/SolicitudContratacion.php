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
use Codedge\Fpdf\Fpdf\Fpdf;

class SolicitudContratacion extends FpdfGlobal implements LetterDownloadInterface
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
        $programName = $this->getNameProgram($program);
        $programType = $this->getTypeProgram($program->tipo);
        $hrsAcademic  = $module->hrs_academicas . " (" . $this->literalNumber($module->hrs_academicas) . ")";
        $literalDate = $this->literalDate($letter->fecha_carta);

        $letterLeaders = LetterLeader::where('letter_id', $letterId)->get();
        if (!$letterLeaders) return false;
        $nameDecano = "No asignado";
        $nameResponsable = "No asignado";
        $nameDirector = "No asignado";
        $nameCoordinador = "No asignado";
        foreach ($letterLeaders as $key => $leader) {
            $leader = Leader::find($leader->leader_id);
            if ($leader->cargo == Position::COORDINADORACADEMICO) {
                $nameCoordinador = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::DECANOFCET) {
                $nameDecano = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::RESPONSABLECONTRATACIONJAF) {
                $nameResponsable = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::DIRECTOREI) {
                $nameDirector = $this->getFullNameLeader($leader);
            }
        }

        // parameters
        $title = $this->utf8_decode("Ref.: SOLICITUD DE CONTRATACION PARA CONSULTOR E INFORME PRESUPUESTARIO.");

        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(25, $this->margin, 20);
        $this->fpdf->SetAutoPageBreak(true, 20);

        // HEADER
        $this->fpdf->Ln(15);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("Santa Cruz de la sierra, " . $literalDate), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("OF. COORD. ACAD. N° " . $letter->codigo_administrativo), 0, 'L', 0);


        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($this->utf8_decode("<A:>        " . $nameDecano));
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->WriteText($this->utf8_decode("           Decano de la F.C.E.T"));
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($this->utf8_decode("           " . $nameResponsable));
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->WriteText($this->utf8_decode("           Responsable de Procesos de Contratación-JAF"));
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($this->utf8_decode("<Via:>     " . $nameDirector));
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->WriteText($this->utf8_decode("           Director Escuela de Ingeniería de la F.C.E.T."));
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($this->utf8_decode("<De:>      " . $nameCoordinador));
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->WriteText($this->utf8_decode("            Coordinador Académico - Escuela de Ingeniería"));
        $this->fpdf->Ln(10);


        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $title, 0, 'C', 0);
        $this->fpdf->Ln(5);

        $contenido = [
            $this->utf8_decode("Mediante la presente solicito contratación de consultor e informe presupuestario para el <MÓDULO> denominado: \"" . $module->nombre . "\", correspondiente " . $programType . "en " . $programName . ". a realizarse en fecha <" . $this->dateFormat($module->fecha_inicio) . " a " . $this->dateFormat($module->fecha_final) . "> . Teniendo una carga horaria de " . $hrsAcademic . " horas Académicas, Se adjunta TDR."),
            $this->utf8_decode("Los fondos están contemplados en el presupuesto de ingresos propios de esta dirección en:"),
        ];
        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($contenido[0]);
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space,  $contenido[1], 0, 'L', 0);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, "ASIGNACION PRESUPUESTARIA", 0, 'L', 0);
        $this->fpdf->Ln(5);

        $wt = $this->width / 20;
        $this->widths = array($wt * 3, $wt, $wt, $wt, $wt * 3, $wt * 2, $wt * 2, $wt * 2, $wt * 3, $wt * 3);
        $this->fpdf->SetFont('Arial', '', 9);
        $options = ["alling" => 'C', "background" => 0, "bold" => "S", "br" => true];
        $this->row(array($this->utf8_decode('CODIGO CATALOGO UNSPSC'), $this->utf8_decode('ENT'), $this->utf8_decode('DA'), $this->utf8_decode('UE'), $this->utf8_decode('CATEGORIA PROG'), $this->utf8_decode('FUENTE'), $this->utf8_decode('ORG'), $this->utf8_decode('PART'), $this->utf8_decode('DESCRIPCION'), $this->utf8_decode('IMPORTE (Bs.)')), $options);
        $options = ["alling" => 'C', "background" => 0, "bold" => "N", "br" => true];
        $this->row(array($parametros["codigo_catalogo"], $parametros["ent"], $parametros["da"], $parametros["ue"], $parametros["categoria_prog"], $parametros["fuente"], $parametros["org"], $parametros["part"], $this->utf8_decode($parametros["descripcion"]), $parametros["importe"]), $options);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Sin otro particular, me despido de usted con las consideraciones más distinguidas"), 0, 'L', 0);
        $this->fpdf->Ln(1);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Atentamente. -"), 0, 'L', 0);
        $this->fpdf->Ln(5);

        // FONT BOLD
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _"), 0, 'C', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode($nameCoordinador), 0, 'C', 0);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("Coordinador Académico"), 0, 'C', 0);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("ESCUELA DE INGENIERÍA"), 0, 'C', 0);

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', '', 8);
        $this->WriteText('KES');
        $this->fpdf->Ln(4);
        $this->fpdf->SetFont('Arial', '', 8);
        $this->WriteText($this->utf8_decode('<C.c/> Coordinación académica'));
        $this->fpdf->Ln(4);
        $this->WriteText('<C.c/> Decanato');
        $this->fpdf->Output("I", "Activos-Fijos.pdf", true);
        exit;
    }
}
