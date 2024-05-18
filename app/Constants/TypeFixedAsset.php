<?php

namespace App\Constants;

class TypeFixedAsset
{
    const LABORATORIOS = "Laboratorios";
    const EQUIPOS_INFORMATICOS = "Equipos informáticos";
    const MOBILIARIO = "Mobiliario y equipo de oficina";
    const RECURSOS_ACADEMICOS = "Recursos académicos";
    const RECURSOS_INFORMATICOS = "Recursos informáticos";
    const PAPELERIA = "Papelería";
    const OTROS = "Otros";


    public static function all(): array
    {
        return [
            self::LABORATORIOS,
            self::EQUIPOS_INFORMATICOS,
            self::MOBILIARIO,
            self::RECURSOS_ACADEMICOS,
            self::RECURSOS_INFORMATICOS,
            self::PAPELERIA,
            self::OTROS,

        ];
    }
}
