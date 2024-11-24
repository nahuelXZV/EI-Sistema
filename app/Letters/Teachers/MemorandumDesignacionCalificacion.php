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

class MemorandumDesignacionCalificacion extends FpdfGlobal implements LetterDownloadInterface
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
        $nameCoordinador = "No asignado";
        $nameResponsable = "No asignado";
        $namePlataforma = "No asignado";
        foreach ($letterLeaders as $key => $leader) {
            $leader = Leader::find($leader->leader_id);
            if ($leader->cargo == Position::COORDINADORACADEMICO) {
                $nameCoordinador = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::RESPONSABLECONTRATACIONJAF) {
                $nameResponsable = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::ENCARGADOPLAFORMAVIRTUAL) {
                $namePlataforma = $this->getFullNameLeader($leader);
            }
        }

        // parameters
        $title = $this->utf8_decode("MEMORANDUM DE DESIGNACION DE CALIFICACION");

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
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $title, 0, 'C', 0);

        $this->widths = array($this->width - 40, 40);
        $options = ["alling" => 'L', "background" => 1, "bold" => "S", "br" => true, "background-color" => "white", 'font-size' => 9];
        $this->RowHeader(array($this->utf8_decode(''), $this->utf8_decode("EI-MR. N° " . $letter->codigo_administrativo)), $options);

        $this->widths = array(14, $this->width - 14);
        $options = ["alling" => 'L', "background" => 1, "bold" => "N", "br" => true, "background-color" => "", 'font-size' => 9];
        $this->RowHeader(array($this->utf8_decode('A:'), $this->utf8_decode($nameCoordinador . " - Coordinador Académico de la EI-FECT- UAGRM.")), $options);
        $options = ["alling" => 'L', "background" => 1, "bold" => "N", "br" => true, "background-color" => "", 'font-size' => 8];
        $this->RowHeader(array($this->utf8_decode('A:'), $this->utf8_decode($namePlataforma . " - ENCARGADO DE PLATAFORMA VIRTUAL ESCUELA DE INGENIERIA - UAGRM.")), $options);
        $options = ["alling" => 'L', "background" => 1, "bold" => "N", "br" => true, "background-color" => "", 'font-size' => 9];
        $this->RowHeader(array($this->utf8_decode('DE:'), $this->utf8_decode($nameResponsable . " - Jefe Administrativo Financiero RPA. FCET- U.A.G.R.M. ")), $options);
        $options = ["alling" => 'L', "background" => 1, "bold" => "S", "br" => true, "background-color" => "", 'font-size' => 9];
        $this->RowHeader(array($this->utf8_decode('Ref:'), $this->utf8_decode("DESIGNACIÓN COMISIÓN DE CALIFICACIÓN DEL PROCESO DE CONTRATACIÓN MENOR DE CONSULTORÍA POR PRODUCTO PARA EL MÓDULO DENOMINADO: \"" . $module->nombre . "\", CORRESPONDIENTE " . $programType . "en " . $programName . ", A EJECUTARSE CON RECURSOS PROPIOS, PLAZO DE EJECUCIÓN 64 HORAS ACADEMICAS POSTERIOR A LA FIRMA EL CONTRATO DE BS " . $contract->honorarios . " (" . $honorariosLiteral . " CON 00/100 BOLIVIANOS). ")), $options);
        $this->fpdf->Ln(2);

        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Santa cruz de la sierra, " . $literalDate), 0, 'R', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("DESIGNACIÓN MIEMBRO DE LA COMISIÓN DE CALIFICACIÓN"), 0, 'L', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("De mi consideración:"), 0, 'L', 0);

        $contenido = [
            $this->utf8_decode("En mi calidad de RPA, designado mediante resolución rectoral Nº " . $parametros["res_rectoral"] . ", procedo a ejecutar las siguientes acciones administrativas, en cumplimiento al artículo 34 del Decreto Supremo 0181 del 28 de junio del 2009, relativo a Normas Básicas de Administración de Bienes y  Servicios N-SABS, dentro de las atribuciones que me competen como Responsable del Proceso de Contratación (RPA), tengo a bien designarle Integrante de la comisión de Calificación para el MODULO DENOMINADO:  \"" . $module->nombre . "\", CORRESPONDIENTE " . $programType . "en " . $programName . ", A EJECUTARSE CON RECURSOS PROPIOS POR EL MONTO DE <BS. " . $contract->honorarios . "> A FAVOR DEL <" . $nameTeacher . ">, actividades que deberá desempeñar conforme a lo señalado en el artículo 38 del Decreto Supremo 0181 del 29 de junio del 2009."),
            $this->utf8_decode("III. El Responsable de Evaluación y la Comisión de Calificación tienen como principales funciones:"),
            $this->utf8_decode("Realizar la apertura de propuestas y lectura de precios ofertados en acto público;"),
            $this->utf8_decode("Efectuar el análisis y evaluación de los documentos técnicos y administrativos;"),
            $this->utf8_decode("Evaluar y calificar las propuestas técnicas y económicas;"),
            $this->utf8_decode("Convocar a todos los proponentes para la aclaración sobre el contenido de una o más propuestas, cuando se considere pertinente, sin que ello modifique la propuesta técnica o la económica;"),
            $this->utf8_decode("Elaborar el Informe de Evaluación y Recomendación de Adjudicación o Declaratoria Desierta para su remisión al RPC o RPA;"),
            $this->utf8_decode("Efectuar la verificación técnica de los documentos presentados por el proponente adjudicado;"),
            $this->utf8_decode("Elaborar cuando corresponda, el informe técnico para la cancelación, suspensión o anulación de un proceso de contratación."),
            $this->utf8_decode("Asimismo, le comunico que su actuación es: <obligatorio, con dedicación exclusiva> a dicho proceso de contratación <sin poder delegar sus funciones ni excusarse de participar>, salvo casos de conflicto de intereses o impedimento físico temporal, conforme a norma vigente."),
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
        $this->fpdf->Ln(2);

        $this->WriteText($contenido[9]);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, "Con este particular saludo a usted muy atentadamente.", 0, 'L', 0);

        $this->fpdf->SetFont('Arial', 'I', 9);
        $this->fpdf->Ln(15);
        $this->fpdf->Line(20, 250, 190, 250);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("Av. Busch Módulo Administrativo                                     Telefax: -0498                                                Casilla N° 702"), 0, 'L', 0);
        $this->fpdf->MultiCell($this->width, 4,  $this->utf8_decode("E-mail:  f_tecnologia@uagrm.edu.bo                               Telf. Piloto: 355-0498                              Santa Cruz-Bolivia"), 0, 'L', 0);


        $this->fpdf->Output("I", "Activos-Fijos.pdf", true);
        exit;
    }
}
