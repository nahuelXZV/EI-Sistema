<?php

namespace App\Letters\Teachers;

use App\Constants\LettersTemplate;
use App\Interfaces\LetterDownloadInterface;
use App\Letters\FpdfGlobal;
use App\Models\Leader;
use App\Models\Letter;
use App\Models\LetterLeader;
use App\Services\Academic\ContractService;
use App\Services\Academic\LetterService;
use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramService;
use App\Services\Academic\TeacherService;
use Codedge\Fpdf\Fpdf\Fpdf;

class NotificacionAdjudicacion extends FpdfGlobal implements LetterDownloadInterface
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
        $solicitudContratacion = Letter::where('contrato_id', $contract->id)->where('nombre', LettersTemplate::SOLICITUDCONTRATACION)->first();
        if (!$solicitudContratacion) return false;

        $programName = $this->getNameProgram($program);
        $programType = $this->getTypeProgram($program->tipo);
        $hrsAcademic  = $module->hrs_academicas;
        $literalDate = $this->literalDate($letter->fecha_carta);

        // parameters
        $title = $this->utf8_decode("REF: NOTIFICACION ADJUDICACION");

        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(20, $this->margin, 20);
        $this->fpdf->SetAutoPageBreak(true, 0);
        $this->fpdf->Ln(15);

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

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("Santa Cruz de la sierra, " . $literalDate), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', 'BU', 10);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("EI-RPA.OF Nº  " . $letter->codigo_administrativo), 0, 'L', 0);

        $this->fpdf->Ln(4);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Señor. - "), 0, 'L', 0);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode($nameTeacher), 0, 'L', 0);     //dinamico
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Presente."), 0, 'L', 0);
        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $title, 0, 'C', 0);
        $this->fpdf->Ln(5);


        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("De mi mayor consideración:"), 0, 'L', 0);
        $this->fpdf->Ln(3);

        $contenido = [
            $this->utf8_decode("En relación del proceso: Requerido con CITE <OF.COORD. ACAD. N.º " . $solicitudContratacion->codigo_administrativo . "> de la Escuela de Ingeniería, Contratación Menor de un Consultor Individual por Producto para el <MÓDULO> denominado: \"" . $module->nombre . "\", correspondiente " . $programType . "en " . $programName . ". a Ejecutarse con Recursos Propios, ya que cuenta con Registro de ejecución de Gastos Preventivo Nº " . $parametros['nro_preventiva'] . "."),
            $this->utf8_decode("En Calidad de Responsable para procesos de contratación de bienes y servicios, en ejercicio de las atribuciones que me confiere el inc. F) del art. 34 de D.S. N°181 y el art. <Primero de la Resolución Rectoral N° " . $parametros['resolucion_rectoral'] . "> y con base en el informe técnico emitido por el <Coordinador Académico ESCUELA DE INGENIERIA - UAGRM> en la cual concluye recomendar <ADJUDICAR LA CONTRATACION MENOR DE UN CONSULTOR POR PRODUCTO PARA el> <MÓDULO> <denominado: \"" . $module->nombre . "\", correspondiente> " . $programType . "<en " . $programName . ">. a ejecutarse con Recursos Propios por el monto de Bs. " . $contract->honorarios . ". - tiempo de ejecución " . $hrsAcademic . " horas académicas. Por cumplir los requisitos, <APRUEBO> el mencionado informe y <ADJUDICO> esta contratación a la persona citada por el motivo mencionado que será formalizada mediante contrato según condiciones establecidas en los términos de referencia."),
            $this->utf8_decode("Para formalizar la contratación, agradeceré pasar por el Dpto. legal de la ESCUELA DE INGENIERIA F.C.E.T., Ubicado en la Av. Bush esq. Raul Bascopé, al lado de los módulos de la UAGRM, a efectos de coordinar con esa instancia, la presentación de los requisitos legales, para suscripción del contrato correspondiente.")
        ];

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($contenido[0]);
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(3);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($contenido[1]);
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(3);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->WriteText($contenido[2]);
        $this->fpdf->Ln(5);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, "Sin otro particular, saludo a usted con las consideraciones del caso.", 0, 'L', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, "Atentamente.", 0, 'L', 0);
        $this->fpdf->Ln(35);

        // FONT BOLD
        $this->fpdf->SetFont('Arial', '', 8);
        $this->WriteText('C.c.: Archivo ESCUELA DE INGENIERIA');
        $this->fpdf->Ln(5);

        // line footer
        $this->fpdf->Ln(5);
        $this->fpdf->Line(20, 250, 190, 250);

        $this->fpdf->SetFont('Arial', 'I', 9);
        $this->fpdf->Ln(7);
        $this->fpdf->MultiCell($this->width, 4, $this->utf8_decode("Av. Busch Módulo Administrativo                                     Telefax: -0498                                                Casilla N° 702"), 0, 'L', 0);
        $this->fpdf->MultiCell($this->width, 4,  $this->utf8_decode("E-mail:  f_tecnologia@uagrm.edu.bo                               Telf. Piloto: 355-0498                              Santa Cruz-Bolivia"), 0, 'L', 0);

        $this->fpdf->Output("I", "Activos-Fijos.pdf", true);
        exit;
    }
}
