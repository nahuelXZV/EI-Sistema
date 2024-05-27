<?php

namespace App\Constants;

class ProgramsTypes
{
    const DOCTORADO = "Doctorado";
    const MAESTRIA = "Maestria";
    const DIPLOMADO = "Diplomado";
    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::DOCTORADO,
            self::MAESTRIA,
            self::DIPLOMADO,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
