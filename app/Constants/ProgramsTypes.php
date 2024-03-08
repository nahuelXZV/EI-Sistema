<?php

namespace App\Constants;

class ProgramsTypes
{
    const DOCTORADO = "Doctorado";
    const MAESTRIA = "Maestria";
    const LICENCIATURA = "Licenciatura";
    const DIPLOMADO = "Diplomado";
    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::DOCTORADO,
            self::MAESTRIA,
            self::LICENCIATURA,
            self::DIPLOMADO,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}