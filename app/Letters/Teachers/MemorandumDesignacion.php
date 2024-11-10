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

class MemorandumDesignacion extends FpdfGlobal implements LetterDownloadInterface
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
        foreach ($letterLeaders as $key => $leader) {
            $leader = Leader::find($leader->leader_id);
            if ($leader->cargo == Position::COORDINADORACADEMICO) {
                $nameCoordinador = $this->getFullNameLeader($leader);
            }
            if ($leader->cargo == Position::RESPONSABLECONTRATACIONJAF) {
                $nameResponsable = $this->getFullNameLeader($leader);
            }
        }

        // parameters
        $title = $this->utf8_decode("MEMORANDUM DE DESIGNACION DE RECEPCION");

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
        $this->RowHeader(array($this->utf8_decode('DE:'), $this->utf8_decode($nameCoordinador . " - Coordinador Académico de la EI-FECT- UAGRM.")), $options);
        $this->RowHeader(array($this->utf8_decode('A:'), $this->utf8_decode($nameResponsable . " - Jefe Administrativo Financiero RPA. FCET- U.A.G.R.M. ")), $options);
        $options = ["alling" => 'L', "background" => 1, "bold" => "S", "br" => true, "background-color" => "", 'font-size' => 9];
        $this->RowHeader(array($this->utf8_decode('Ref:'), $this->utf8_decode("DESIGNACIÓN COMISIÓN DE RECEPCIÓN Y FISCAL DE SERVICIO DEL CONTRATO ADMINISTRATIVO (MODALIDAD MENOR) Nº " . $parametros['nro_contrato'] . " A FAVOR DE " . $nameTeacher . " - CONTRATACIÓN MENOR DE CONSULTORÍA POR PRODUCTO PARA EL MÓDULO DENOMINADO: \"" . $module->nombre . "\", CORRESPONDIENTE " . $programType . "en " . $programName . ", A EJECUTARSE CON RECURSOS PROPIOS, PLAZO DE EJECUCIÓN 64 HORAS ACADEMICAS POSTERIOR A LA FIRMA EL CONTRATO DE BS " . $contract->honorarios . " (" . $honorariosLiteral . " CON 00/100 BOLIVIANOS). ")), $options);
        $this->fpdf->Ln(2);

        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("Santa cruz de la sierra, " . $literalDate), 0, 'R', 0);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("De mi consideración:"), 0, 'L', 0);
        $this->fpdf->Ln(3);

        $contenido = [
            $this->utf8_decode("Resultado de la Convocatoria de referencia, requerida   por usted, se adjudicó la misma A FAVOR DEL <" . $nameTeacher . ">, importe total de Bs.- " . $contract->honorarios . " (" . $honorariosLiteral . " CON 00/100 BOLIVIANOS). Plazo de ejecución conforme establece el contrato es de 64 horas Académicas posterior a la firma del contrato. Forma de Pago como señala el contrato y los Términos de Referencias se efectuarán mediante pago total del módulo terminado, deberá elaborar los informes de recepción de los servicios prestados por el Consultor adjudicado, y Recepción del servicio, en el plazo contractual.  "),
            $this->utf8_decode("Asimismo, a efectos de recepción parcial y final del servicio contratado, en aplicación de la Resolución Rectoral Nº " . $parametros["res_rectoral"] . ", designo a Ud. Responsable de Recepción del Servicio y fiscal del servicio; debiendo cumplir sus funciones, establecidas en el Art. 39 del DS 181, mismas que son de carácter obligatorio Debiendo a la conclusión Elaborar el Acta de Conformidad del Servicio, en el plazo que establece el contrato."),
            $this->utf8_decode("D.S. 181 ART. 39 - II. El Responsable de Recepción y la Comisión de Recepción, Tiene como principales funciones: \na) Efectuar la Recepción de los bienes y servicios y dar conformidad verificando el cumplimiento de las especificaciones técnicas y/o términos de referencias."),
            $this->utf8_decode("b) Elaborar y firmar el acta de Recepción o emitir el informe de conformidad, según corresponda, aspecto que no exime las responsabilidades del proveedor ni del supervisor respecto de la entrega del bien o servicio. \nc) Elabora el informe de Disconformidad, cuando corresponda."),
            $this->utf8_decode("Para el efecto, conforme a normas y contrato, en su calidad de Responsable de la Recepción del servicio y responsable de la fiscalización correspondiente; para este cometido, remito fotocopias de contrato, la propuesta adjudicada en base a los Términos de Referencia, para control de estas condiciones, por parte de los miembros de la comisión de recepción designados en la presente comunicación interna, deberán remitir a la GERENCIA las actas de recepción."),
            $this->utf8_decode("En Atención y cumpliendo A RECOMENDACIÓN DEL INFORME DE AUDITORIA Nº UM7SG-N01/A14(S/01) DE LA AUDITORIA DE CONFIABILIDAD DE LOS REGISTROS Y ESTADOS FINANCIEROS DE LA UAGRM CORRESPONDIENTE A LA GESTION 2015, se recuerda que la no implementación de recomendaciones puede originar responsabilidades por la función pública, por tal motivo instruyo a Ud. Adoptar las medidas necesarias para el cumplimiento en la fecha establecida en el cronograma de Recepción de bienes y servicios. \nCon este motivo, saludo a ustedes con la mayor atención."),
            $this->utf8_decode(""),
        ];

        $this->fpdf->SetFont('Arial', '', 9);
        $this->WriteText($contenido[0]);
        $this->fpdf->Ln(5);

        $this->WriteText($contenido[1]);
        $this->fpdf->Ln(5);

        $this->WriteText($contenido[2]);
        $this->fpdf->Ln(5);

        $this->WriteText($contenido[3]);
        $this->fpdf->Ln(7);

        $this->WriteText($contenido[4]);
        $this->fpdf->Ln(7);

        $this->WriteText($contenido[5]);

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
