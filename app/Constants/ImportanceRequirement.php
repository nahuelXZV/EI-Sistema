<?php

namespace App\Constants;

class ImportanceRequirement
{
    const HIGH = "Alta";
    const MEDIUM = "Media";
    const LOW = "Baja";

    public static function all(): array
    {
        return [
            self::HIGH,
            self::MEDIUM,
            self::LOW,
        ];
    }
}

