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
use Codedge\Fpdf\Fpdf\Fpdf;

class PropuestaConsultor extends FpdfGlobal implements LetterDownloadInterface
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

        $letterLeaders = LetterLeader::where('letter_id', $letterId)->first();
        if (!$letterLeaders) return false;
        $leader = Leader::find($letterLeaders->leader_id);
        $fullnameLeader = $this->getFullNameLeader($leader) ?? "No asignado";

        // parameters
        $title = $this->utf8_decode("Ref.: SOLICITUD DE CONTRATACION PARA CONSULTOR E INFORME PRESUPUESTARIO.");

        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(25, $this->margin, 20);
        $this->fpdf->SetAutoPageBreak(true, 20);

        $this->fpdf->Ln(17);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $title, 0, 'C', 0);
        $this->fpdf->Ln(5);

        // pie de pagina
        $this->fpdf->Ln(12);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("Santa Cruz de la sierra, " . $this->literalDate($letter->fecha_carta) . "."), 0, 'C', 0);
        $this->fpdf->Ln(35);

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
