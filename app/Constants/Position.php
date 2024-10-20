<?php

namespace App\Constants;

class Position
{
    const COORDINADORACADEMICO = "Coordinador Académico";
    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::COORDINADORACADEMICO,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
