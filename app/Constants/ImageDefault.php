<?php

namespace App\Constants;

class ImageDefault
{
    const USER = "person_default.webp";

    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::USER,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
