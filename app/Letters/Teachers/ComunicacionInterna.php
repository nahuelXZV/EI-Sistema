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

class ComunicacionInterna extends FpdfGlobal implements LetterDownloadInterface
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

        $programName = $this->getNameProgram($program);
        $programType = $this->getTypeProgram($program->tipo);
        $hrsAcademic  = $module->hrs_academicas . " (" . $this->literalNumber($module->hrs_academicas) . ")";
        $literalDate = $this->literalDate($letter->fecha_carta);
        $honorariosLiteral = $this->literalNumber($contract->honorarios);
        $programType = str_replace("<", "", $programType);
        $programType = str_replace(">", "", $programType);

        $letterLeaders = LetterLeader::where('letter_id', $letterId)->get();
        if (!$letterLeaders) return false;
        $nameAsesor = "No asignado";
        $nameDirector = "No asignado";
        $nameResponsable = "No asignado";
        foreach ($letterLeaders as $key => $leader) {
            $leader = Leader::find($leader->leader_id);
            if ($leader->cargo == Position::ASESORLEGAL) {
                $nameAsesor = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::DECANOFCET) {
                $nameDirector = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::RESPONSABLECONTRATACIONJAF) {
                $nameResponsable = $this->getFullNameLeader($leader);
            }
        }

        // parameters
        $title = $this->utf8_decode("COMUNICACIÓN INTERNA");

        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(25, $this->margin, 20);
        $this->fpdf->SetAutoPageBreak(true, 20);

        // HEADERs
        // HEADER
        $this->fpdf->Image('imgs/logo-facultad-izq.jpeg', 20, 5, 20, 22);
        $this->fpdf->Image('imgs/logo-facultad.jpeg', $this->width + 10, 5, 20, 22);
        // position
        $this->fpdf->SetY(10);
        $this->fpdf->SetX(25);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("UNIVERSIDAD AUTONOMA \"GABRIEL RENÉ MORENO\""), 0, 'C', 0);
        $this->fpdf->SetX(25);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("Facultad de Ciencias Exactas y Tecnología"), 0, 'C', 0);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetX(25);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("JEFATURA DE ADMINISTRACION Y FINANZAS"), 0, 'C', 0);
        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $title, 0, 'C', 0);
        $this->fpdf->Ln(5);

        $this->widths = array($this->width - 40, 40);
        $options = ["alling" => 'L', "background" => 1, "bold" => "S", "br" => true, "background-color" => "white", 'font-size' => 9];
        $this->RowHeader(array($this->utf8_decode(''), $this->utf8_decode("EI-EC No. " . $letter->codigo_administrativo)), $options);

        $this->widths = array(14, $this->width - 14);
        $options = ["alling" => 'L', "background" => 1, "bold" => "N", "br" => true, "background-color" => "", 'font-size' => 9];
        $this->RowHeader(array($this->utf8_decode('A:'), $this->utf8_decode($nameAsesor . " - ASESOR LEGAL F.C.E.T. - UAGRM.")), $options);
        $this->RowHeader(array($this->utf8_decode('VIA:'), $this->utf8_decode($nameDirector . " - DIRECTOR DE LA ESCUELA DE INGENIERIA F.C.E.T.")), $options);
        $this->RowHeader(array($this->utf8_decode('DE:'), $this->utf8_decode($nameResponsable . " - RESPONSABLE DEL PROCESO DE CONTRATACION.")), $options);
        $options = ["alling" => 'L', "background" => 1, "bold" => "S", "br" => true, "background-color" => "", 'font-size' => 9];
        $this->RowHeader(array($this->utf8_decode('REF:'), $this->utf8_decode("SOLICITUD DE REVISIÓN DE DOCUMENTACIÓN Y ELABORACIÓN DE CONTRATO A FAVOR DE " . strtoupper($nameTeacher) . " - CONTRATACIÓN MENOR DE CONSULTORÍA POR PRODUCTO PARA EL MÓDULO DENOMINADO: \"" . strtoupper($module->nombre) . "\", CORRESPONDIENTE " . strtoupper($programType) . "en " . strtoupper($programName) . ", A EJECUTARSE CON RECURSOS PROPIOS,POR UN MONTO DE BS " . $contract->honorarios . " (" . strtoupper($honorariosLiteral) . " CON 00/100 BOLIVIANOS). A REALIZARSE EN UN PLAZO DE 64 HORAS ACADEMICAS")), $options);
        $this->fpdf->Ln(2);

        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Santa cruz de la sierra, " . $literalDate), 0, 'R', 0);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("De mi consideración:"), 0, 'L', 0);
        $this->fpdf->Ln(3);

        $contenido = [
            $this->utf8_decode(" Según el oficio OF.COORD. ACAD. N.º  " . $parametros["numero_oficio"] . " del Coordinador Académico de la ESCUELA DE INGENIERIA - UAGRM, remito a usted la integridad del proceso de Contratación para el ,<MODULO> DENOMINADO:  \"" . $module->nombre . "\", CORRESPONDIENTE <" . $programType . "> en " . $programName . ". (UNA CARPETA), efectos de la recepción y verificación de la documentación requerida para la elaboración y firma del contrato."),
            $this->utf8_decode("Proceda a ejecutar las siguientes acciones: En sujeción al D.S. 181 art. 37.- (ASESORIA LEGAL). En cada proceso de contratación, tiene como principales funciones:"),
            $this->utf8_decode("Atender y asesorar en la revisión de documentos y asuntos legales que sean sometidos a su consideración durante el proceso de contratación."),
            $this->utf8_decode("Elaborar todos los informes legales requeridos en el proceso de contratación."),
            $this->utf8_decode("Elaborar los contratos para los procesos de contratación."),
            $this->utf8_decode("Firmar o visar el contrato de forma previa a su suscripción, como responsable de su elaboración."),
            $this->utf8_decode("Revisar la legalidad de la documentación presentada por el proponente adjudicado para la suscripción del contrato."),
            $this->utf8_decode("Atender y asesorar en procedimientos, plazos y resolución de Recursos Administrativos de impugnación."),
            $this->utf8_decode("Elaborar y visar todas las Resoluciones establecidas en las presentes NB-SABS."),
            $this->utf8_decode("Elaborar el informe."),
        ];

        $this->fpdf->SetFont('Arial', '', 9);
        $this->WriteText($contenido[0]);
        $this->fpdf->Ln(7);

        $this->WriteText($contenido[1]);
        $this->fpdf->Ln(7);

        $this->MultiCellBlt($this->width - 10, 4, "a)", $contenido[2]);
        $this->MultiCellBlt($this->width - 10, 4, "b)", $contenido[3]);
        $this->MultiCellBlt($this->width - 10, 4, "c)", $contenido[4]);
        $this->MultiCellBlt($this->width - 10, 4, "d)", $contenido[5]);
        $this->MultiCellBlt($this->width - 10, 4, "e)", $contenido[6]);
        $this->MultiCellBlt($this->width - 10, 4, "f)", $contenido[7]);
        $this->MultiCellBlt($this->width - 10, 4, "g)", $contenido[8]);
        $this->MultiCellBlt($this->width - 10, 4, "H)", $contenido[9]);

        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, "Con este motivo, saludo a usted atentamente.", 0, 'L', 0);

        // line footer

        $this->fpdf->Ln(5);
        $this->fpdf->Line(20, 250, 190, 250);

        $this->fpdf->SetFont('Arial', 'I', 9);
        $this->fpdf->Ln(25);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("Av. Busch Módulo Administrativo                                     Telefax: -0498                                                Casilla N° 702"), 0, 'L', 0);
        $this->fpdf->MultiCell($this->width, 4,  $this->utf8_decode("E-mail:  f_tecnologia@uagrm.edu.bo                               Telf. Piloto: 355-0498                              Santa Cruz-Bolivia"), 0, 'L', 0);


        $this->fpdf->Output("I", "Activos-Fijos.pdf", true);
        exit;
    }
}
