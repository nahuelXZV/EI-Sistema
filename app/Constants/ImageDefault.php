<?php

namespace App\Constants;

class ImageDefault
{
    const USER = "person_default.webp";
    const INVENTORY = "no_image.jpg";

    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::USER,
            self::INVENTORY,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
