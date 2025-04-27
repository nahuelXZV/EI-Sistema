<?php

namespace App\Pdfs;

use App\Interfaces\LetterDownloadInterface;
use App\Letters\FpdfGlobal as LettersFpdfGlobal;
use App\Models\Program;
use App\Services\Academic\ProgramService;
use App\Services\Academic\RegistrationFormService;
use Codedge\Fpdf\Fpdf\Fpdf;

class RegistrationFormPDF extends LettersFpdfGlobal implements LetterDownloadInterface
{
    public function download($id)
    {
        $this->fpdf = new Fpdf('P', 'mm', 'letter');
        $this->fpdf->header('Content-type: application/pdf');
        $this->fpdf->header('Content-Disposition: inline; filename="formulario-inscripcion.pdf"');

        $data = RegistrationFormService::getOne($id);
        $program = ProgramService::getOne($data->programa_id);
        $url = config('app.url_web_student') . $data->url_foto;
        $tamañoPapel = 220;
        $nacionalidad = $data->es_boliviano ? "Boliviano" : "Extranjero";


        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(25, $this->margin, 20);
        $this->fpdf->SetAutoPageBreak(true, 20);

        $this->fpdf->Image('imgs/logo.png', 10, 10, 50, 20);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(0, 10, $this->utf8_decode("                UNIVERSIDAD AUTONOMA \"GABRIEL RENÉ MORENO\""), 0, 0, 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(0, 10, $this->utf8_decode("Facultad de Ciencias Exactas y Tecnología"), 0, 0, 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(0, 10, $this->utf8_decode("Escuela de ingeniería"), 0, 0, 'C');
        $this->fpdf->Image($url, $this->width + 10, 10, 25, 25);

        // cuadrado rojo
        $this->fpdf->SetFillColor(220, 38, 38);
        $this->fpdf->Rect(0, 37, $tamañoPapel, 10, 'F');
        $this->fpdf->SetTextColor(255, 255, 255);

        // titulo
        $this->fpdf->SetY(38);
        $this->fpdf->SetX(0);
        $this->fpdf->SetFont('Arial', 'B', 14);
        $this->fpdf->Cell($tamañoPapel, 10, $this->utf8_decode("FORMULARIO DE INSCRIPCIÓN"), 0, 0, 'C', true);

        // datos del programa
        $height = 55;
        $tab = 30;
        $this->fpdf->SetFillColor(30, 58, 138);
        $this->fpdf->Rect(0, $height, $tamañoPapel, 10, 'F');
        $this->fpdf->SetTextColor(255, 255, 255);

        $this->fpdf->SetY($height);
        $this->fpdf->SetX(0);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell($tamañoPapel, 10, $this->utf8_decode("Datos del Programa"), 0, 0, 'C');

        $this->fpdf->SetY(68);
        $this->fpdf->SetX(10);
        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab, 10, $this->utf8_decode("PROGRAMA:"), 0, 0, 'L');
        $this->fpdf->Cell(10, 10, $this->utf8_decode($program->nombre), 0, 0, 'L');
        $this->fpdf->Ln(5);

        $this->fpdf->SetX(10);
        $this->fpdf->Cell($tab, 10, $this->utf8_decode("VERSION:"), 0, 0, 'L');
        $this->fpdf->Cell(10, 10, $this->utf8_decode($program->version . '.' . $program->edicion), 0, 0, 'L');

        $height = 86;
        // datos del estudiantes
        $this->fpdf->SetFillColor(30, 58, 138);
        $this->fpdf->Rect(0, $height, $tamañoPapel, 10, 'F');
        $this->fpdf->SetTextColor(255, 255, 255);

        $this->fpdf->SetY($height);
        $this->fpdf->SetX(0);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell($tamañoPapel, 10, $this->utf8_decode("Datos Personales del Postgraduante"), 0, 0, 'C');

        $this->fpdf->SetY($height + 13);
        $this->fpdf->SetX(10);
        $this->fpdf->SetTextColor(0, 0, 0);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 10, 10, $this->utf8_decode("Nombre y Apellidos:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tamañoPapel - $tab - 33, 10, $this->utf8_decode($data->nombre_completo), 1, 0, 'L');


        $height = 107;
        $this->fpdf->SetY($height);
        $this->fpdf->Ln(5);
        $this->fpdf->SetX(10);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 10, 10, $this->utf8_decode("Género:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 20, 10, $this->utf8_decode($data->genero), 1, 0, 'L');
        $this->fpdf->SetX($tamañoPapel / 2);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 25, 10, $this->utf8_decode("Nacionalidad:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 12, 10, $this->utf8_decode($nacionalidad), 1, 0, 'L');

        $height = 120;
        $this->fpdf->SetY($height);
        $this->fpdf->Ln(5);
        $this->fpdf->SetX(10);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 10, 10, $this->utf8_decode("Carnet de Identidad:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 20, 10, $this->utf8_decode($data->ci . " " . $data->ci_expedicion), 1, 0, 'L');
        $this->fpdf->SetX($tamañoPapel / 2);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 25, 10, $this->utf8_decode("Pasaporte:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 11, 10, $this->utf8_decode($data->pasaporte), 1, 0, 'L');

        $height = 133;
        $this->fpdf->SetY($height);
        $this->fpdf->Ln(5);
        $this->fpdf->SetX(10);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 10, 10, $this->utf8_decode("WhatsApp:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 20, 10, $this->utf8_decode($data->whatsapp), 1, 0, 'L');
        $this->fpdf->SetX($tamañoPapel / 2);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell($tab, 10, $this->utf8_decode("E-mail:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 36, 10, $this->utf8_decode($data->email), 1, 0, 'L');

        $height = 146;
        $this->fpdf->SetY($height);
        $this->fpdf->Ln(5);
        $this->fpdf->SetX(10);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab, 10, $this->utf8_decode("Profesión:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 30, 10, $this->utf8_decode($data->profesion), 1, 0, 'L');
        $this->fpdf->SetX($tamañoPapel / 2);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 15, 10, $this->utf8_decode("Universidad de Origen:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 22, 10, $this->utf8_decode($data->universidad_origen), 1, 0, 'L');

        $height = 159;
        $this->fpdf->SetY($height);
        $this->fpdf->Ln(5);
        $this->fpdf->SetX(10);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 10, 10, $this->utf8_decode("Año de Egreso:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 20, 10, $this->utf8_decode($data->anio_egreso), 1, 0, 'L');
        $this->fpdf->SetX($tamañoPapel / 2);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 25, 10, $this->utf8_decode("N° de Registro en la UAGRM:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tab + 12, 10, $this->utf8_decode($data->registro_uagrm), 1, 0, 'L');

        $height = 172;
        $this->fpdf->SetY($height);
        $this->fpdf->Ln(5);
        $this->fpdf->SetX(10);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell($tab + 30, 10, $this->utf8_decode("Institución en la que trabaja:"), 1, 0, 'L');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell($tamañoPapel - 83, 10, $this->utf8_decode($data->institucion_trabajo), 1, 0, 'L');


        // datos experiencia laboral
        $height = 194;
        $this->fpdf->SetFillColor(30, 58, 138);
        $this->fpdf->Rect(0, $height, $tamañoPapel, 10, 'F');
        $this->fpdf->SetTextColor(255, 255, 255);

        $this->fpdf->SetY($height);
        $this->fpdf->SetX(0);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Cell($tamañoPapel, 10, $this->utf8_decode("Experiencia Laboral"), 0, 0, 'C');
        $this->fpdf->Ln(15);

        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->SetX(10);
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->MultiCell($tamañoPapel - 21, 4, $this->utf8_decode("Si viene de otras universidades, agradecemos por la confianza en la Escuela de ingeniería, estamos seguros de que su inversión en este programa potenciará su perfil profesional y lo promoverá como un profesional más competitivo."), 0, 'J');

        $this->fpdf->Ln(5);
        $this->fpdf->SetX(10);
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($tamañoPapel - 21, 5, $this->utf8_decode($data->experiencia_laboral), 1, 'J');

        // linea
        $height = 250;
        $this->fpdf->SetY($height);
        $this->fpdf->SetX(10);
        $this->fpdf->SetLineWidth(0.5);
        $this->fpdf->Line(5, $height, $tamañoPapel - 8, $height);

        // 3 logos centrados

        $x = ($tamañoPapel - 60) / 2;
        $this->fpdf->SetY($height + 5);
        $this->fpdf->SetX(0);
        $this->fpdf->Image('imgs/fcet.png', $x, $height + 5, 15, 15);
        $this->fpdf->Image('imgs/uagrm.png', $x + 20, $height + 5, 15, 15);
        $this->fpdf->Image('imgs/ei-logo.png', $x + 40, $height + 5, 15, 15);

        $this->fpdf->Output("I", "formulario-inscripcion.pdf", true);
        exit;
    }
}
