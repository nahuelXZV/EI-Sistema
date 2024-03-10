<?php

namespace App\Constants;

class Modality
{
    const PRESENCIAL = "Presencial";
    const SEMIPRESENCIAL = "Semipresencial";
    const VIRTUAL = "Virtual";

    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::PRESENCIAL,
            self::SEMIPRESENCIAL,
            self::VIRTUAL,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
