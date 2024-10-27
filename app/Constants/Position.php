<?php

namespace App\Constants;

class Position
{
    const COORDINADORACADEMICO = "Coordinador Académico";
    const DECANOFCET = "Decano de la F.C.E.T";
    const RESPONSABLECONTRATACIONJAF = "Responsable de Procesos de Contratación";
    const DIRECTOREI = "Director Escuela de Ingeniería de la F.C.E.T";
    const ENCARGADOPLAFORMAVIRTUAL = "Encargado de Plataforma Virtual E.I.";
    const JEFEADMINISTRATIVOFINANCIERO = " Jefe Administrativo Financiero RPA. FCET";

    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::COORDINADORACADEMICO,
            self::DECANOFCET,
            self::RESPONSABLECONTRATACIONJAF,
            self::DIRECTOREI,
            self::ENCARGADOPLAFORMAVIRTUAL,
            self::JEFEADMINISTRATIVOFINANCIERO,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
