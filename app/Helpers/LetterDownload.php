<?php

namespace App\Helpers;

use App\Constants\LettersTemplate;
use App\Letters\Teachers\TerminoReferencia;

class LetterDownload
{
    public function download($letterId, $typeLetter)
    {
        // Seleccionar la clase según el tipo de carta
        $letterClass = $this->selectType($typeLetter);
        // Crear una instancia de la clase seleccionada
        $letterSelected = new $letterClass();
        // Retornar la respuesta
        return $letterSelected->download($letterId);
    }

    private function selectType($typeLetter)
    {
        $class = [
            LettersTemplate::TERMINOREFERENCIA => TerminoReferencia::class,
            // Agrega más tipos y clases según sea necesario
        ];
        // Verificar si existe el tipo de carta, de lo contrario, lanzar una excepción
        if (!array_key_exists($typeLetter, $class)) {
            abort(400, "Tipo de carta no válido.");
        }
        return $class[$typeLetter];
    }
}
