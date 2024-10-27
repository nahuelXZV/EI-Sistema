<?php

namespace App\Constants;

class LettersTemplate
{
    // contrato docentes
    const TERMINOREFERENCIA = "Termino de referencia";
    const SOLICITUDCONTRATACION = "Solicitud de contratación";
    const REQUERIMIENTOPROPUESTA = "Requerimiento de propuesta";
    const PROPUESTACONSULTOR = "Propuesta de consultor";

    // contrato administrativoa

    public static function getTemplateLettersTeachers(): array
    {
        return [
            [
                'title' => self::TERMINOREFERENCIA,
                'route' => 'letter.termino-referencia',
            ],
            [
                'title' => self::SOLICITUDCONTRATACION,
                'route' => 'letter.solicitud-contratacion',
            ],
            [
                'title' => self::REQUERIMIENTOPROPUESTA,
                'route' => 'letter.requerimiento-propuesta',
            ],
            [
                'title' => self::PROPUESTACONSULTOR,
                'route' => 'letter.propuesta-consultor',
            ],
        ];
    }

    public static function getTemplateLetterAdmin(): array
    {
        return [];
    }
}
