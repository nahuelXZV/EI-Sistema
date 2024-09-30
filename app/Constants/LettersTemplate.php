<?php

namespace App\Constants;

class LettersTemplate
{
    // contrato docentes
    const TERMINOREFERENCIA = "Termino de referencia";

    // contrato administrativo

    public static function getTemplateLettersTeachers(): array
    {
        return [
            [
                'title' => self::TERMINOREFERENCIA,
                'route' => 'letter.termino-referencia',
            ]
        ];
    }

    public static function getTemplateLetterAdmin(): array
    {
        return [];
    }
}
