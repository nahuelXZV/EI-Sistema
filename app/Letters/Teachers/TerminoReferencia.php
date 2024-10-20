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

class TerminoReferencia extends FpdfGlobal implements LetterDownloadInterface
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
        dd($letterLeaders);
        if (!$letterLeaders) return false;
        dd('here');
        $leader = Leader::find($letterLeaders->leader_id);
        $fullnameLeader = $this->getFullNameLeader($leader) ?? "No asignado";

        // parameters
        $title = $this->utf8_decode("CONDICIONES Y TÉRMINOS PARA CONTRATACION DE CONSULTORES POR PRODUCTO PARA EL DESARROLLO DE MODULOS DE PROGRAMAS ACADEMICOS DE POST GRADO y/o CAPACITACIONES CONTINUA DE LA ESCUELA DE INGENIERIA - FCET - UAGRM.");

        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(25, $this->margin, 20);
        $this->fpdf->SetAutoPageBreak(true, 20);

        $this->fpdf->Ln(17);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $title, 0, 'C', 0);
        $this->fpdf->Ln(5);

        //cuerpo del reporte
        $antecedentes = [
            $this->utf8_decode("Por mandato de la antigua Constitución política del Estado boliviano, en su artículo 189 y en la Actual Constitución Política del Estado Plurinacional de Bolivia en su artículo 90 Numeral I y II, la Universidad Autónoma Gabriel René Moreno en el CAPÍTULO SEGUNDO, en su artículo 13 y 17 del nuevo Estatuto Orgánico reconoce e identifica las actividades que deben desempeñar los institutos de capacitación."),
            $this->utf8_decode("La UAGRM, mediante la Resolución Rectoral N° 105/97 de fecha 31 de julio de 1997 en su artículo 1° resuelve, instruir a los señores decanos la inmediata creación de la unidad de postgrado facultativa."),
            $this->utf8_decode("La Facultad de Ciencias Exactas y Tecnología crea el departamento de postgrado facultativo mediante Resolución de Decanatura 025/97"),
            $this->utf8_decode("La UAGRM, mediante la Resolución Rectoral N° 416 -2006 de fecha 29 de Diciembre en su artículo 1° resuelve, homologar en todos sus términos y partes la resolución vicerrectoral N° 457/06 de 22/12/2006, y autorizar al instituto de excelencia en los negocios del gas, energía e hidrocarburos (INEGAS), la estructuración y ejecución de programas de actualización, capacitación continua, post grado a nivel de diplomado, especialidad, maestría y doctorado."),
            $this->utf8_decode("Posteriormente la UAGRM, mediante Resolución Rectoral N°129-2018, en su artículo 1° consolida al instituto para la Excelencia en los Negocios del gas, Energía e Hidrocarburos, dentro de la estructura administrativa, dependiente de rectorado de la UAGRM y, en su artículo 6° instruye a la Escuela de Post Grado de la UAGRM para que a través del órgano correspondiente, incorpore los programas académicos para las áreas del conocimiento de la cadena productiva del gas, energía e hidrocarburos, emitiendo la Escuela de Post Grado de la UAGRM, el titulo correspondiente a los postgraduantes y egresados que cumplan con las exigencias académicas."),
            $this->utf8_decode("La resolución rectoral N°221/2021 y Comunicación Interna N°447/2021 de 08 de junio de 2021 la cual resuelve transferir la institución para la excelencia en los negocios del gas, energía e hidrocarburos (INEGAS) a la facultad de ciencias exactas y tecnología (FCET)."),
            $this->utf8_decode("Finalmente, las Resoluciones de Decanatura 009/2022, 010/2022 y 011/2022, aprueban, respectivamente, la transferencia, el organigrama y el cambio de nombre de la Unidad de Postgrado a Escuela de Ingeniería."),
        ];

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("1.- ANTECEDENTES: "), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln($this->ln);
        $this->fpdf->MultiCell($this->width, $this->space, $antecedentes[0], 0, 'J', 0);
        $this->fpdf->Ln($this->ln);
        $this->fpdf->MultiCell($this->width, $this->space, $antecedentes[1], 0, 'J', 0);
        $this->fpdf->Ln($this->ln);
        $this->fpdf->MultiCell($this->width, $this->space, $antecedentes[2], 0, 'J', 0);
        $this->fpdf->Ln($this->ln);
        $this->fpdf->MultiCell($this->width, $this->space, $antecedentes[3], 0, 'J', 0);
        $this->fpdf->Ln($this->ln);
        $this->fpdf->MultiCell($this->width, $this->space, $antecedentes[4], 0, 'J', 0);
        $this->fpdf->Ln($this->ln);
        $this->fpdf->MultiCell($this->width, $this->space, $antecedentes[5], 0, 'J', 0);
        $this->fpdf->Ln($this->ln);
        $this->fpdf->MultiCell($this->width, $this->space, $antecedentes[6], 0, 'J', 0);
        $this->fpdf->Ln(5);


        $objetivos = [
            $this->utf8_decode("Cumplir rol de facilitador en el proceso de enseñanza y aprendizaje en los módulos académicos de postgrado u/o capacitación continua de la Escuela de Ingeniería de FCET; así mismo formar profesionales con competencias teóricas, analíticas y prácticas."),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("2.- OBJETIVO DE LA CONTRATACIÓN: "), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $objetivos[0], 0, 'J', 0);
        $this->fpdf->Ln(5);


        $referencia = [
            $this->utf8_decode("El Consultor para el establecimiento y cumplimiento de su contrato, deberá tener presente y cumplir el presente documento y los siguientes instrumentos normativos: "),
            $this->utf8_decode("El Reglamento General del Sistema de Postgrado de la Universidad Autónoma Gabriel René Moreno."),
            $this->utf8_decode("El Decreto Supremo 181."),
            $this->utf8_decode("Ley Financial.")
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("3.- MARCO DE REFERENCIA: "), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell($this->width, $this->space, $referencia[0], 0, 'J', 0);
        $this->fpdf->Ln($this->ln);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(2);
        $this->MultiCellBlt($this->width - 10, 4, 1., $referencia[1]);
        $this->MultiCellBlt($this->width - 10, 4, 2., $referencia[2]);
        $this->MultiCellBlt($this->width - 10, 4, 3., $referencia[3]);
        $this->fpdf->Ln(5);


        $actividades = [
            $this->utf8_decode("El Consultor, además de las condiciones establecidas en el Contrato y los señalados en el marco de referencia, deberá cumplir con las siguientes actividades y condiciones específicas para el desarrollo de la docencia en el Módulo para el cual será contratado."),
            $this->utf8_decode("Ejecutar el programa analítico de la materia a impartir bajo el diseño curricular por competencias."),
            $this->utf8_decode("Capacitar alumnos mediante diferentes metodologías (según propuesta)."),
            $this->utf8_decode("Compatibilizar los programas establecidos y los sugeridos por el docente (Actualizaciones)"),
            $this->utf8_decode("Revisión de programas para establecer su pertinencia."),
            $this->utf8_decode("Análisis de la Bibliografía utilizada y ofertada en el medio."),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("4.- ACTIVIDADES Y CONDICIONES ESPECÍFICAS QUE DEBEN SER CUMPLIDAS POR EL CONSULTOR. "), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);

        $this->fpdf->MultiCell($this->width, $this->space, $actividades[0], 0, 'J', 0);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Ln(4);
        $this->fpdf->MultiCell($this->width, $this->space,  $this->utf8_decode("Las actividades específicas son:"), 0, 'J', 0);

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $actividades[1]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $actividades[2]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $actividades[3]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $actividades[4]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $actividades[5]);
        $this->fpdf->Ln(5);

        $perfil = [
            $this->utf8_decode("Formación: " . $parametros['formacion']),
            $this->utf8_decode("Experiencia General: " . $parametros['experiencia_general']),
            $this->utf8_decode("Formacion contínua: " . $parametros['formacion_continua']),
            $this->utf8_decode("Nacionalidad: Boliviana; Extranjero con residencia en el país y/o permiso de trabajo."),
        ];

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("5.- PERFIL REQUERIDO DEL CONSULTOR"), 0, 'L', 0);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $perfil[0]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $perfil[1]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $perfil[2]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $perfil[3]);
        $this->fpdf->Ln(5);


        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("6.- INFORMACIÓN DE REFERENCIA DEL CONTRATO PARA EL CONSULTOR."), 0, 'L', 0);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $this->utf8_decode("PROGRAMAS: " . $this->getNameProgram($program)));
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $this->utf8_decode("MODULO: " . $module->nombre));
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $this->utf8_decode("HORAS ACADÉMICAS: " . $module->hrs_academicas . "Hrs"));
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $this->utf8_decode("HONORARIOS: Bs"  . $contract->honorarios . "  (Total Ganado)."));
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $this->utf8_decode("FECHA DEL MODULO: " . $this->dateFormat($module->fecha_inicio) . " al " . $this->dateFormat($module->fecha_final) . "."));
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $this->utf8_decode("HORARIO: " . $contract->horario));
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $this->utf8_decode("Validez de la propuesta: 30 días calendario"));
        $this->fpdf->Ln(5);


        $lugar = [
            $this->utf8_decode("El lugar de la consultoría será realizado en la Escuela de ingeniería, ubicada en la Av. Busch esq. Raúl Bascope, entre 2do y 3er anillo en la ciudad de SANTA CRUZ DE LA SIERRA. (MODALIDAD PRESENCIAL) o mediante la plataforma virtual: UPCET: Todos los cursos (ei-uagrm.edu.bo) (MODALIDAD VIRTUAL)."),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("7.- LUGAR "), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $lugar[0], 0, 'J', 0);
        $this->fpdf->Ln(5);


        $asistencia = [
            $this->utf8_decode("Deberá cumplir estrictamente el horario señalado en el punto 6 y presentarse en el aula diez minutos antes del inicio de clases, para ver si están los materiales y equipos necesarios; en caso de no tenerlos, podrá dirigirse a Apoyo Académico o Seguimiento Académico para darle una solución inmediata (MODALIDAD PRESENCIAL) o presentar el material digital en los formatos correspondientes requeridos por la Escuela de Ingeniería, antes del inicio de las clases, para poder cumplir con los procesos de edición, configuración, articulación y cargar a su aula virtual. en caso de no tener completos los materiales de estudio, imposibilitaría el inicio del módulo (MODALIDAD VIRTUAL)."),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("8.- ASISTENCIA Y PUNTUALIDAD DEL CONSULTOR."), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $asistencia[0], 0, 'J', 0);
        $this->fpdf->Ln(5);


        $supervisacion = [
            $this->utf8_decode("El Consultor desempeñará sus funciones bajo la supervisión de la COORDINACION ACADEMICA de la Escuela de Ingeniería. "),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("9.- SUPERVISIÓN ORGANIZACIÓN Y DIRECCIÓN DEL PROYECTO."), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $supervisacion[0]);
        $this->fpdf->Ln(5);


        $informe_final = [
            $this->utf8_decode("Para efectos del cierre del módulo deberá entregar en los siguientes SIETE DÍAS HÁBILES DE LA FINALIZACIÓN DEL MISMO, lo siguiente:"),
            $this->utf8_decode("Informe Académico del consultor (informe de conclusión)."),
            $this->utf8_decode("Planilla de notas en el formulario que le será entregado oportunamente por la Escuela de Ingeniería "),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("10.- INFORMES FINALES"), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $informe_final[0], 0, 'J', 0);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->MultiCellBlt($this->width - 10, 4, "-", $informe_final[1]);
        $this->MultiCellBlt($this->width - 10, 4, "-", $informe_final[2]);
        $this->fpdf->Ln(5);

        $contrato = [
            $this->utf8_decode("El pago del honorario se efectuará previa <PRESENTACIÓN DEL INFORME ACADÉMICO Y ACTA DE NOTA> por parte del consultor finalizado el modulo por el cual fue contratado. Dicho informe y acta de nota será entregado al COORDINADOR ACADEMICO de la escuela de ingeniería. Quien elaborará un informe de conformidad y al mismo tiempo solicitará el pago respectivo, dirigido al <DIRECTOR DE LA ESCUELA DE INGENIERIA>, el mismo instruirá a las instancias correspondientes el pago del consultor, mediante una solicitud firmado por su autoridad, siguiendo los procedimientos administrativos correspondientes. "),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("11.- CONTRATO Y FORMA DE PAGO"), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->WriteText($contrato[0]);
        $this->fpdf->Ln(5);

        $propuesta = [
            $this->utf8_decode("El Consultor ofertante debe presentar:"),
            $this->utf8_decode("Carta dirigida a la unidad solicitante con Ref.: Propuesta consultor."),
            $this->utf8_decode("Propuesta técnica (programa de asignatura) para la realización de la Consultoría, indicando: Objetivo, Metodología y evaluación, con el formato de programa de asignatura."),
            $this->utf8_decode("Curriculum Vitae."),
            $this->utf8_decode("Título nivel licenciatura (título de profesional)."),
            $this->utf8_decode("Título de Maestría si corresponde."),
            $this->utf8_decode("Fotocopia de Carnet de Identidad."),
        ];
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("12.- PROPUESTA"), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $propuesta[0], 0, 'J', 0);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[1]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[2]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[3]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[4]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[5]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $propuesta[6]);
        $this->fpdf->Ln(5);


        $modalidad = [
            $this->utf8_decode("El consultor será contratado bajo la modalidad de Servicios de Consultoría Individual por Producto bajo la modalidad de Contratación Menor."),
            $this->utf8_decode("La evaluación de la selección se hará por el método de selección basado en el Presupuesto fijo."),
            $this->utf8_decode("El consultor, durante el periodo de contratación, tendrá como sede las instalaciones de la Escuela de Ingeniería en la Av. Busch, esq. Raúl Bascope. "),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("13.- MODALIDAD DE CONTRATACIÓN Y EVALUACIÓN DE PROPUESTAS"), 0, 'L', 0);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('Arial', '', 10);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $modalidad[0]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $modalidad[1]);
        $this->MultiCellBlt($this->width - 10, 4, chr(149), $modalidad[2]);
        // $this->fpdf->Ln(5);

        $cuadro_evaluativo = [
            $this->utf8_decode("CUADRO DE CALIFICACION"),
            $this->utf8_decode("La propuesta que no alcance los 50 puntos en la evolución de la misma, será descalificada"),
            $this->utf8_decode("1.- PUNTAJE DE EVALUACION CUMPLE/ NO CUMPLE"),
            $this->utf8_decode("1.1	FORMACION: " . $parametros['formacion']),
            $this->utf8_decode("1.2 CURSOS DE FORMACION CONTINUA: " . $parametros['formacion_continua']),
            $this->utf8_decode("1.3 EXPERIENCIA GENERAL:  " . $parametros['experiencia_general']),
            $this->utf8_decode("1.4 NACIONALIDAD: Boliviana; Extranjero con residencia en el país y/o permiso de trabajo."),
        ];

        $this->fpdf->AddPage();

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("14.- CUADRO DE EVALUACION Y CALIFICACION AL CONSULTOR."), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Ln(2);

        $this->fpdf->MultiCell($this->width, $this->space, $cuadro_evaluativo[0], 0, 'C', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $cuadro_evaluativo[1], 0, 'C', 0);

        // Table
        $this->widths = array($this->width);
        $this->fpdf->SetFont('Arial', '', 10);
        $options = ["alling" => 'C', "background" => 1, "bold" => "N", "br" => true];
        $this->row(array($this->utf8_decode('FORMULARIO C1')), $options);
        $this->row(array($this->utf8_decode('FORMACION Y EXPERIENCIA')), $options);
        $this->row(array($this->utf8_decode('CONDICIONES MINIMA REQUERIDAS')), $options);

        $this->widths = array($this->width / 2, ($this->width / 2) / 3, ($this->width / 2) / 3, ($this->width / 2) / 3);
        $this->row(array($cuadro_evaluativo[2], $this->utf8_decode('PUNTAJE'), $this->utf8_decode('CUMPLE'), $this->utf8_decode('NO CUMPLE')));
        $this->row(array($cuadro_evaluativo[3], $this->utf8_decode('15'), $this->utf8_decode("SI"), $this->utf8_decode(" ")));
        $this->row(array($cuadro_evaluativo[4], '10', "SI", ""));
        $this->row(array($cuadro_evaluativo[5], '10', "SI", ""));
        $this->row(array($cuadro_evaluativo[6], ' ', "SI", ""));

        $this->widths = array($this->width / 2, ($this->width / 2) / 3, ($this->width / 2) * 2 / 3);
        $this->row(array($this->utf8_decode('TOTAL'), $this->utf8_decode('35 Puntos'),  $this->utf8_decode('')));
        $this->widths = array($this->width / 2, $this->width / 2);
        $this->row(array($this->utf8_decode('METODOLOGIA: CUMPLE/ NO CUMPLE'), $this->utf8_decode('por asignar')));
        $this->fpdf->Ln(2);



        $t = $this->width / 2;
        $this->widths = array($this->width);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->widths = array(($this->width / 2) / 3 + ($this->width / 2), ($this->width / 2) / 3, ($this->width / 2) / 3);
        $this->row(array($this->utf8_decode('                                             FORMULARIO C2                                                                                                                                                                 2.- PUNTAJE DE LAS CONDICIONES ADICIONALES'), $this->utf8_decode('      Puntaje                              ASIGNADO'), $this->utf8_decode('Condiciones adicionales propuesta.')), $options);

        $this->widths = array($this->width);
        $options = ["alling" => 'C', "background" => 0, "bold" => "S", "br" => true];
        $this->row(array($this->utf8_decode('EXPERIENCIA ESPECIFICA')), $options);

        $this->widths = array(($t / 3) / 2);
        $options = ["alling" => 'C', "background" => 0, "bold" => "N", "br" => false, "mul" => 4];
        $this->rowM(array($this->utf8_decode("1")), $options);

        $options = ["alling" => 'L', "background" => 0, "bold" => "S", "br" => true];
        $this->widths = array($t + ($t / 3) / 2, $t / 3 + $t / 3);
        $this->row(array($this->utf8_decode('(Experiencia laboral) Instituciones Públicas y Privadas.'), $this->utf8_decode('')), $options);

        $x = $this->fpdf->GetX();
        $y = $this->fpdf->GetY();
        $this->fpdf->SetXY($x + ($t / 3) / 2, $y);

        $options = ["alling" => 'L', "background" => 0, "bold" => "N", "br" => false];
        $this->widths = array($t + ($t / 3) / 2,);
        $this->row(array($this->utf8_decode('* Menor a 1 año (5 puntos)')), $options);

        $options = ["alling" => 'C', "background" => 0, "bold" => "N", "br" => true, "mul" => 3];
        $this->widths = array($t / 3, $t / 3);
        $this->rowM(array($this->utf8_decode(10), $this->utf8_decode(' ')), $options);

        $this->widths = array($t + ($t / 3) / 2);
        $x = $this->fpdf->GetX();
        $y = $this->fpdf->GetY();
        $this->fpdf->SetXY($x + ($t / 3) / 2, $y);
        $options = ["alling" => 'L', "background" => 0, "bold" => "N", "br" => true];
        $this->row(array($this->utf8_decode('* entre 1 a 2 años (8 puntos)')), $options);

        $x = $this->fpdf->GetX();
        $y = $this->fpdf->GetY();
        $this->fpdf->SetXY($x + ($t / 3) / 2, $y);
        $this->row(array($this->utf8_decode('* Mayor o igual a 3 años (10 puntos)')), $options);

        // //----------------------------------
        $this->widths = array($this->width);
        $options = ["alling" => 'C', "background" => 0, "bold" => "S", "br" => true];
        $this->row(array($this->utf8_decode('CURSOS DE FORMACION CONTINUA')), $options);

        $this->widths = array(($t / 3) / 2); //, $t / 3, $t / 3
        $options = ["alling" => 'C', "background" => 0, "bold" => "S", "br" => false, "mul" => 4];
        $this->rowM(array($this->utf8_decode("2")), $options);

        $this->widths = array($t + ($t / 3) / 2, $t / 3 + $t / 3);
        $options = ["alling" => 'L', "background" => 0, "bold" => "N", "br" => true];
        $this->row(array($this->utf8_decode('(Seminarios, Cursos, Talleres, Simposios u otros)'), $this->utf8_decode('')), $options);

        $x = $this->fpdf->GetX();
        $y = $this->fpdf->GetY();
        $this->fpdf->SetXY($x + ($t / 3) / 2, $y);
        $this->widths = array($t + ($t / 3) / 2); //, $t / 3, $t / 3
        $options = ["alling" => 'L', "background" => 0, "bold" => "N", "br" => false];
        $this->row(array($this->utf8_decode('* Tiene mayor o igual a 2 certificados (1 puntos)')), $options);

        $this->widths = array($t / 3, $t / 3); //, $t / 3, $t / 3
        $options = ["alling" => 'C', "background" => 0, "bold" => "S", "br" => true, "mul" => 3];
        $this->rowM(array($this->utf8_decode(5), $this->utf8_decode(' ')), $options);

        $this->widths = array($t + ($t / 3) / 2); //, $t / 3, $t / 3
        $x = $this->fpdf->GetX();
        $y = $this->fpdf->GetY();
        $this->fpdf->SetXY($x + ($t / 3) / 2, $y);
        $options = ["alling" => 'L', "background" => 0, "bold" => "N", "br" => true];
        $this->row(array($this->utf8_decode('* Tiene mayor o igual a 4 certificados (3 puntos)')), $options);
        $x = $this->fpdf->GetX();
        $y = $this->fpdf->GetY();
        $this->fpdf->SetXY($x + ($t / 3) / 2, $y);
        $this->row(array($this->utf8_decode('* Tiene mayor o igual a 6 certificados (5 puntos)')), $options);


        // //---------------------------------------
        $this->widths = array($this->width);
        $options = ["alling" => 'C', "background" => 0, "bold" => "S", "br" => true];
        $this->row(array($this->utf8_decode('PROPUESTA TECNICA')), $options);
        $options = ["alling" => 'L', "background" => 0, "bold" => "N", "br" => true];
        $this->widths = array(($t / 3) / 2, $t + ($t / 3) / 2, $t / 3, $t / 3);
        $this->row(array($this->utf8_decode('     3'), $this->utf8_decode('*Objetivo y desarrollo de las actividades (20 puntos)'), $this->utf8_decode("           20"), $this->utf8_decode(' ')), $options);

        $this->widths = array(($this->width / 2) / 3 + ($this->width / 2), ($this->width / 2) / 3, ($this->width / 2) / 3);
        $this->row(array($this->utf8_decode('                                                       TOTAL'), $this->utf8_decode('      35 Puntos'), $this->utf8_decode('')), $options);


        $this->fpdf->AddPage();
        $resumen = [
            "1.- PUNTAJE DE EVALUACION CUMPLE/ NO CUMPLE",
            "2.- PUNTAJE DE LAS CONDICIONES ADICIONALES",
        ];
        $t = $this->width / 2;
        $options = ["alling" => 'C', "background" => 1, "bold" => "S", "br" => true];
        $this->widths = array($t, $t / 2, $t / 2);
        $this->row(array($this->utf8_decode('                                                                                               RESUMEN DEL FORUMARIO C1 Y C2                                   '), $this->utf8_decode('                                                PUNTAJE TOTAL                                          '), $this->utf8_decode('                              PUNTAJE OBTENIDO                                     ')), $options);
        $options = ["alling" => 'C', "background" => 0, "bold" => "S", "br" => true];
        $this->row(array($resumen[0], $this->utf8_decode('35 Puntos'), $this->utf8_decode('')), $options);
        $this->row(array($resumen[1],  $this->utf8_decode('35 Puntos'),  $this->utf8_decode('')), $options);
        $this->row(array($this->utf8_decode("                          TOTAL PUNTAJE"), $this->utf8_decode('70 Puntos'), $this->utf8_decode('')), $options);
        $this->fpdf->Ln(5);



        $multas = [
            $this->utf8_decode("El consultor se obliga a cumplir con el cronograma y el plazo de entrega establecido para cada materia y/o Módulos, caso contrario será multado con el 0,5 % por día de retraso."),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("15. MULTAS POR INCUMPLIMIENTO"), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $multas[0], 0, 'J', 0);
        $this->fpdf->Ln(5);

        $garantia = [
            $this->utf8_decode("Para el proponente adjudicado, en caso de que aplique, de acuerdo al Art. 21 inciso b) del Decreto Supremo 0181, se procederá a la retención del 7% sobre el monto del pago parcial como “Garantía de Cumplimiento de Contrato”, debiendo ser devuelto al finalizar el servicio"),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("16. GARANTIA DE CUMPLIMIENTO DE CONTRATO"), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $garantia[0], 0, 'J', 0);
        $this->fpdf->Ln(5);

        $pago_impuesto = [
            $this->utf8_decode($parametros['pago_impuesto']),
        ];
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, $this->utf8_decode("17. PAGO DE IMPUESTOS "), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(5);
        $this->fpdf->MultiCell($this->width, $this->space, $pago_impuesto[0], 0, 'J', 0);
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
        dd('ok');
        exit;
    }
}
